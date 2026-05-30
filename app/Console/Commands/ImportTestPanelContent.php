<?php

namespace App\Console\Commands;

use App\Models\TestPanel;
use App\Models\TestPanelContentBlock;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use App\Models\TestPanelRelatedPanel;
use App\Models\TestPanelFaq;

class ImportTestPanelContent extends Command

{
    protected $signature = 'import:test-panel-content';

    protected $description = 'Import test panel content blocks and block items from JSON files';

    public function handle(): int
    {
        $blocksPath = database_path('content/panels/test_panel_content_blocks.json');
        $itemsPath = database_path('content/panels/test_panel_content_block_items.json');
        $relatedPath = database_path('content/panels/test_panel_related_panels.json');
        $faqsPath = database_path('content/panels/test_panel_faqs.json');

        if (!File::exists($blocksPath)) {
            $this->error("Blocks file not found: {$blocksPath}");
            return self::FAILURE;
        }

        if (!File::exists($itemsPath)) {
            $this->error("Items file not found: {$itemsPath}");
            return self::FAILURE;
        }

        if (!File::exists($relatedPath)) {
            $this->error("Related panels file not found: {$relatedPath}");
            return self::FAILURE;
        }

        if (!File::exists($faqsPath)) {
            $this->error("FAQs file not found: {$faqsPath}");
            return self::FAILURE;
        }

        $blocksData = json_decode(File::get($blocksPath), true);
        $itemsData = json_decode(File::get($itemsPath), true);
        $relatedData = json_decode(File::get($relatedPath), true);
        $faqsData = json_decode(File::get($faqsPath), true);

        if (!isset($blocksData['blocks']) || !is_array($blocksData['blocks'])) {
            $this->error('Invalid blocks JSON. Expected blocks[]');
            return self::FAILURE;
        }

        if (!isset($itemsData['items']) || !is_array($itemsData['items'])) {
            $this->error('Invalid items JSON. Expected items[]');
            return self::FAILURE;
        }

        if (!isset($relatedData['related_panels']) || !is_array($relatedData['related_panels'])) {
            $this->error('Invalid related panels JSON. Expected related_panels[]');
            return self::FAILURE;
        }

        if (!isset($faqsData['faqs']) || !is_array($faqsData['faqs'])) {
            $this->error('Invalid FAQs JSON. Expected faqs[]');
            return self::FAILURE;
        }

        $this->importBlocks($blocksData['blocks']);
        $this->importItems($itemsData['items']);
        $this->importRelatedPanels($relatedData['related_panels']);
        $this->importFaqs($faqsData['faqs']);
        $this->info('Test panel content imported successfully.');

        return self::SUCCESS;
    }

    private function importBlocks(array $blocks): void
    {
        foreach ($blocks as $blockData) {
            $panelSlug = $blockData['panel_slug'] ?? null;
            $type = $blockData['type'] ?? null;

            if (!$panelSlug || !$type) {
                $this->warn('Skipped block without panel_slug or type');
                continue;
            }

            $panel = TestPanel::where('slug', $panelSlug)->first();

            if (!$panel) {
                $this->warn("Panel not found for block: {$panelSlug}");
                continue;
            }

            TestPanelContentBlock::updateOrCreate(
                [
                    'test_panel_id' => $panel->id,
                    'type' => $type,
                ],
                [
                    'title' => $blockData['title'] ?? $type,
                    'description' => $blockData['description'] ?? null,
                    'sort_order' => $blockData['sort_order'] ?? 100,
                    'is_active' => $blockData['is_active'] ?? true,
                ]
            );
        }
    }

    private function importItems(array $items): void
    {
        foreach ($items as $itemData) {
            $panelSlug = $itemData['panel_slug'] ?? null;
            $blockType = $itemData['block_type'] ?? null;
            $title = $itemData['title'] ?? null;

            if (!$panelSlug || !$blockType || !$title) {
                $this->warn('Skipped item without panel_slug, block_type or title');
                continue;
            }

            $panel = TestPanel::where('slug', $panelSlug)->first();

            if (!$panel) {
                $this->warn("Panel not found for item: {$panelSlug}");
                continue;
            }

            $block = TestPanelContentBlock::where('test_panel_id', $panel->id)
                ->where('type', $blockType)
                ->first();

            if (!$block) {
                $this->warn("Block not found for item: {$panelSlug} / {$blockType}");
                continue;
            }

            $block->items()->updateOrCreate(
                [
                    'title' => $title,
                ],
                [
                    'description' => $itemData['description'] ?? null,
                    'sort_order' => $itemData['sort_order'] ?? 100,
                    'meta' => $itemData['meta'] ?? null,
                ]
            );
        }
    }

    private function importRelatedPanels(array $relatedPanels): void
    {
        foreach ($relatedPanels as $relationData) {
            $panelSlug = $relationData['panel_slug'] ?? null;
            $relatedPanelSlug = $relationData['related_panel_slug'] ?? null;

            if (!$panelSlug || !$relatedPanelSlug) {
                $this->warn('Skipped related panel without panel_slug or related_panel_slug');
                continue;
            }

            $panel = TestPanel::where('slug', $panelSlug)->first();
            $relatedPanel = TestPanel::where('slug', $relatedPanelSlug)->first();

            if (!$panel) {
                $this->warn("Panel not found for related panel: {$panelSlug}");
                continue;
            }

            if (!$relatedPanel) {
                $this->warn("Related panel not found: {$relatedPanelSlug}");
                continue;
            }

            TestPanelRelatedPanel::updateOrCreate(
                [
                    'test_panel_id' => $panel->id,
                    'related_test_panel_id' => $relatedPanel->id,
                ],
                [
                    'title' => $relationData['title'] ?? $relatedPanel->name,
                    'description' => $relationData['description'] ?? $relatedPanel->short_description,
                    'sort_order' => $relationData['sort_order'] ?? 100,
                    'is_active' => $relationData['is_active'] ?? true,
                ]
            );
        }
    }

    private function importFaqs(array $faqs): void
    {
        foreach ($faqs as $faqData) {

            $panelSlug = $faqData['panel_slug'] ?? null;

            if (!$panelSlug) {
                $this->warn('Skipped FAQ without panel_slug');
                continue;
            }

            $panel = TestPanel::where('slug', $panelSlug)->first();

            if (!$panel) {
                $this->warn("Panel not found for FAQ: {$panelSlug}");
                continue;
            }

            TestPanelFaq::updateOrCreate(
                [
                    'test_panel_id' => $panel->id,
                    'question' => $faqData['question'],
                ],
                [
                    'answer' => $faqData['answer'],
                    'sort_order' => $faqData['sort_order'] ?? 100,
                    'is_active' => $faqData['is_active'] ?? true,
                ]
            );
        }
    }
}