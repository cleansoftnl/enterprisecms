<?php namespace WebEd\Plugins\Blocks\Shortcode;

use WebEd\Base\Shortcode\Renderer\AbstractShortcodeRenderer;
use WebEd\Base\Shortcode\Renderer\Contracts\ShortcodeRendererContract;
use WebEd\Plugins\Blocks\Models\Block;
use WebEd\Plugins\Blocks\Repositories\BlockRepository;
use WebEd\Plugins\Blocks\Repositories\Contracts\BlockRepositoryContract;

class BlockShortcodeRenderer extends AbstractShortcodeRenderer implements ShortcodeRendererContract
{
    /**
     * @var array|null
     */
    protected $currentTheme;

    /**
     * @var BlockRepository
     */
    protected $repository;

    /**
     * @var Block
     */
    protected $block;

    public function __construct(BlockRepositoryContract $repository)
    {
        $this->repository = $repository;

        $this->currentTheme = themes_management()->getCurrentTheme();

        $this->themeRenderer = $this->getThemeRenderer('Block');
    }

    /**
     * @var \WebEd\Base\Shortcode\Compilers\Shortcode $shortcode
     * @var string $content
     * @var \WebEd\Base\Shortcode\Compilers\ShortcodeCompiler $compiler
     * @var string $name
     * @return mixed|string
     */
    public function handle($shortcode, $content, $compiler, $name)
    {
        $this->block = $this->repository->find($shortcode->id);
        if (!$this->block) {
            return null;
        }

        if ($this->themeRenderer) {
            return $this->themeRenderer->handle($this->block, $shortcode->toArray());
        }

        return $this->block->content;
    }
}
