<?php
declare(strict_types=1);

// ListStoneController.php
// Controller für die Listenansicht der Steine in der einzelnen Gruppe

namespace Simplesigns\MlStonelexicon\Controller;

use TYPO3\CMS\Core\Context\Context;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Frontend\ContentObject\ContentObjectRenderer;
use TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface;

class ListStones
{
    protected ContentObjectRenderer $cObj;
    protected ConfigurationManagerInterface $configurationManager;

    public function __construct(?ContentObjectRenderer $cObj = null, ConfigurationManagerInterface $configurationManager)
    {
        $this->cObj = $cObj ?? GeneralUtility::makeInstance(ContentObjectRenderer::class);
        $this->configurationManager = $configurationManager;
    }

    public function listRecordsOnPage(string $content, array $conf): string
    {
        $currentPage = GeneralUtility::makeInstance(Context::class)->getPropertyFromAspect('typoscript', 'frontend.page.id', 0);
        $itemsPerPage = $conf['itemsPerPage'] ?? 10; // Standardwert zurück
        $currentPageNumber = (int)($GLOBALS['TYPO3_REQUEST']->getParsedBody()['page'] ?? $GLOBALS['TYPO3_REQUEST']->getQueryParams()['page'] ?? null) ?: 1;
        $offset = ($currentPageNumber - 1) * $itemsPerPage;

        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        $queryBuilder->select('header')
            ->from('tt_content')
            ->where($queryBuilder->expr()->eq('pid', (int)$currentPage))
            ->setMaxResults($itemsPerPage)
            ->setFirstResult($offset)
            ->orderBy('sorting', 'ASC');

        $result = $queryBuilder->execute()->fetchAll();
        $output = array_map(fn($row) => $row['header'], $result);

        $paginationLinks = $this->generatePaginationLinks($currentPage, $itemsPerPage, $currentPageNumber);

        return implode(', ', $output) . '<br>' . $paginationLinks;
    }

    protected function getTotalRecordsCount(int $currentPage): int
    {
        $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('tt_content');
        return (int)$queryBuilder->count('uid')
            ->from('tt_content')->where($queryBuilder->expr()->eq('pid', $currentPage))->executeQuery()
            ->fetchColumn(0);
    }

    protected function generatePaginationLinks(int $currentPage, int $itemsPerPage, int $currentPageNumber): string
    {
        $totalRecords = $this->getTotalRecordsCount($currentPage);
        $totalPages = ceil($totalRecords / $itemsPerPage);
        $paginationLinks = '';

        for ($i = 1; $i <= $totalPages; $i++) {
            $activeClass = $i === $currentPageNumber ? 'active' : '';
            $paginationLinks .= "<a href=\"?page=$i\" class=\"$activeClass\">$i</a> ";
        }

        return $paginationLinks;
    }
}
