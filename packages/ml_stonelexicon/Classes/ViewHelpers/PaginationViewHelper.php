<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\ViewHelpers;

use TYPO3Fluid\Fluid\Core\Rendering\RenderingContextInterface;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class PaginationViewHelper extends AbstractViewHelper
{
    /**
     * Render the pagination links.
     *
     * @return string Rendered pagination links.
     */
    public function render(): string
    {
        $currentPage = $this->arguments['currentPage'];
        $totalPages = $this->arguments['totalPages'];
        $paginationLinks = '';
        if ($totalPages > 1) {
            $paginationLinks .= '<ul class="pagination">';

            // Previous page link
            if ($currentPage > 1) {
                $paginationLinks .= '<li><a href="?page=' . ($currentPage - 1) . '" aria-label="Previous"><span aria-hidden="true">&laquo;</span></a></li>';
            }

            // Page links
            for ($i = 1; $i <= $totalPages; $i++) {
                $paginationLinks .= '<li' . ($currentPage == $i ? ' class="active"' : '') . '><a href="?page=' . $i . '">' . $i . '</a></li>';
            }

            // Next page link
            if ($currentPage < $totalPages) {
                $paginationLinks .= '<li><a href="?page=' . ($currentPage + 1) . '" aria-label="Next"><span aria-hidden="true">&raquo;</span></a></li>';
            }

            $paginationLinks .= '</ul>';
        }
        return $paginationLinks;
    }

    public function initializeArguments(): void
    {
        parent::initializeArguments();
        $this->registerArgument('currentPage', 'int', 'The current page number.', true);
        $this->registerArgument('totalPages', 'int', 'The total number of pages.', true);
    }
}

