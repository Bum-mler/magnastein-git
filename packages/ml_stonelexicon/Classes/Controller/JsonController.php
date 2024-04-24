<?php

namespace Simplesigns\MlStonelexicon\Controller;

// JsonController.php
// Spezialisiert auf die Bereitstellung von Daten im JSON-Format und für AJAX-Anfragen
// Ermöglicht die dynamische Interaktion mit dem Frontend, indem Daten basierend auf einem Suchbegriff geliefert werden.

use Doctrine\DBAL\Connection;
use TYPO3\CMS\Core\Database\ConnectionPool;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3\CMS\Extbase\Mvc\Web\Routing\UriBuilder;

class JsonController
{
    /**
     * @var UriBuilder
     */
    protected $uriBuilder;

    /**
     * Konstruktorinjektion für UriBuilder
     *
     * @param UriBuilder $uriBuilder
     */
    public function __construct(UriBuilder $uriBuilder)
    {
        $this->uriBuilder = $uriBuilder;
    }

    /**
     * @return string
     */
    public function listAction(): string
    {
        $term = $GLOBALS['TYPO3_REQUEST']->getParsedBody()['term'] ?? $GLOBALS['TYPO3_REQUEST']->getQueryParams()['term'] ?? null;

        if (!empty($term)) {
            $queryBuilder = GeneralUtility::makeInstance(ConnectionPool::class)->getQueryBuilderForTable('pages');
            
            $preparedSearch = array_map(
                static fn($s) => $queryBuilder->like('title', '%' . $s . '%'),
                explode(' ', trim($term), 5)
            );

            $pids = [169]; // Definiere deine PID-Werte

            $conditions = [
                ...$preparedSearch,
                $queryBuilder->expr()->in('pid', $queryBuilder->createNamedParameter($pids, Connection::PARAM_INT_ARRAY)),
                $queryBuilder->expr()->in('doktype', $queryBuilder->createNamedParameter([169], Connection::PARAM_INT_ARRAY))
            ];
            
            $result = $queryBuilder->select('*')
                ->from('pages')
                ->where(
                    ...$conditions
                )
                ->executeQuery()
                ->fetchAll();

            $output = [];

            foreach ($result as $singleResult) {
                $output[] = [
                    'id' => $singleResult['uid'],
                    'label' => $singleResult['title'],
                    'value' => $this->uriBuilder->reset()
                        ->setTargetPageUid((int)$singleResult['uid'])
                        ->buildFrontendUri(),
                ];
            }

            return json_encode($output);
        }

        return '';
    }
}
