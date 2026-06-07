<?php
// app/Services/AssetTagService.php

namespace App\Services;

use App\Models\Asset;
use App\Models\AssetCategory;
use App\Models\Setting;

class AssetTagService
{
    /**
     * Generate the next asset tag based on configured format
     *
     * Format placeholders:
     * {ORG_CODE}  - Organisation code from settings
     * {CAT_CODE}  - Category code
     * {YEAR}      - 4-digit current year
     * {YEAR2}     - 2-digit current year
     * {MONTH}     - 2-digit current month
     * {SEQ}       - Auto-incremented sequence number
     */
    public function generate(int $categoryId): string
    {
        $category = AssetCategory::findOrFail($categoryId);

        $format   = Setting::get('asset_tag.format', '{ORG_CODE}-{CAT_CODE}-{YEAR}-{SEQ}');
        $orgCode  = Setting::get('asset_tag.org_code', 'GOV');
        $seqDigits = (int) Setting::get('asset_tag.seq_digits', 4);

        // Calculate next sequence for this category+year
        $year  = now()->format('Y');
        $month = now()->format('m');

        $lastAsset = Asset::where('asset_tag', 'like', "%{$category->code}%{$year}%")
                          ->orderByDesc('id')
                          ->first();

        // Extract last sequence number
        $lastSeq = 0;
        if ($lastAsset) {
            preg_match('/(\d+)$/', $lastAsset->asset_tag, $matches);
            $lastSeq = isset($matches[1]) ? (int) $matches[1] : 0;
        }

        $seq = str_pad($lastSeq + 1, $seqDigits, '0', STR_PAD_LEFT);

        $tag = str_replace(
            ['{ORG_CODE}', '{CAT_CODE}', '{YEAR}', '{YEAR2}', '{MONTH}', '{SEQ}'],
            [$orgCode, $category->code, $year, substr($year, -2), $month, $seq],
            $format
        );

        // Ensure uniqueness
        if (Asset::where('asset_tag', $tag)->exists()) {
            $seq = str_pad($lastSeq + 2, $seqDigits, '0', STR_PAD_LEFT);
            $tag = str_replace('{SEQ}', $seq, $format);
        }

        return strtoupper($tag);
    }
}
