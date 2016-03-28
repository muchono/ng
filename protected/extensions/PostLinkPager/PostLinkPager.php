<?php

class PostLinkPager extends CLinkPager
{
    public $header = '';
    public $firstPageLabel = 'First page';
    public $lastPageLabel = 'Last page';
    
    public $nextPageLabel = 'Next page';
    public $prevPageLabel = 'Previous page';
    
    public $internalPageCssClass = '';
    public $hiddenPageCssClass='hide';
	public $selectedPageCssClass='active';
    
	/**
	 * @var string the CSS class for the first page button. Defaults to 'first'.
	 * @since 1.1.11
	 */
	public $firstPageCssClass='hide';
	/**
	 * @var string the CSS class for the last page button. Defaults to 'last'.
	 * @since 1.1.11
	 */
	public $lastPageCssClass='hide';
	/**
	 * @var string the CSS class for the previous page button. Defaults to 'previous'.
	 * @since 1.1.11
	 */
	public $previousPageCssClass='left';
	/**
	 * @var string the CSS class for the next page button. Defaults to 'next'.
	 * @since 1.1.11
	 */
	public $nextPageCssClass='right';
}