<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Domain\Repository;
// PageRepository.php
use TYPO3\CMS\Core\Http\ApplicationType;
use TYPO3\CMS\Core\Utility\BackendUtility;
use TYPO3\CMS\Extbase\Persistence\QueryInterface;
use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use TYPO3\CMS\Extbase\Persistence\Repository;
use TYPO3\CMS\Extbase\Persistence\Generic\Storage\Typo3DbQueryParser;
use TYPO3\CMS\Extbase\Utility\DebuggerUtility;

class PageRepository extends Repository
{
    protected $defaultOrderings = ['pid' => QueryInterface::ORDER_ASCENDING, 'title' => QueryInterface::ORDER_ASCENDING];

    /**
     * @param array $pids
     * @return array|QueryResultInterface
     */
    public function findForListRaw($pids = [])
    {
        $pids = array_map('intval', $pids);

        if (ApplicationType::fromRequest($GLOBALS['TYPO3_REQUEST'])->isFrontend()) {
            $enableFields = $GLOBALS['TSFE']->sys_page->enableFields('pages', 0);
        } else {
            $enableFields = ' AND `pages`.`deleted` = 0';
            $enableFields .= BackendUtility::BEenableFields('pages');
        }

        $sql = 'SELECT pages.* FROM pages WHERE ((
          pages.pid IN (' . implode(',', $pids) . ')
          AND pages.doktype IN (169)' .
          $enableFields .
          ' LIMIT ' . (int)$queryLimit;

        $query = $this->createQuery();
        $query->statement($sql);
        return $query->execute(false);
    }

    /**
     * @param array $pids
     * @return array|QueryResultInterface
     */
    public function findAll($pids = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
    
        if (!empty($pids)) {
            $condition = $query->in('pid', $pids);
            $query->matching($condition);
        }
    
        return $query->execute();
    }

    /**
     * @param array $pids
     * @return array|QueryResultInterface
     */
    public function findUid($pids = [])
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);

        $conditions = [];
        $conditions[] = $query->in('uid', $pids);
        $query->matching(
            $query->logicalAnd($conditions)
        );

        return $query->execute();
    }

    /**
     * Findet Seiten basierend auf Filtern und unterstützt Paginierung.
     *
     * @param array  $pids
     * @param string $string
     * @param string $color
     * @param string $origin
     * @param int    $limit  Anzahl der Ergebnisse pro Seite
     * @param int    $offset Versatz für die Ergebnisse, basierend auf der aktuellen Seite
     * @return QueryResultInterface Die gefilterten Seiten
     */
    public function findByFilter($pids = [], $string, $color, $origin, $limit = 10, $offset = 0)
    {
        $query = $this->createQuery();
        $query->getQuerySettings()->setRespectStoragePage(false);
    
        $constraints = [];
    
        // Grundlegende Einschränkungen
        if (!empty($pids)) {
            $constraints[] = $query->in('pid', $pids);
        }
        $constraints[] = $query->in('doktype', [169]);
    
        // Suchbedingungen
        if (!empty($string)) {
            $preparedSearch = explode(' ', trim(urldecode($string)), 5);
            $searchConstraints = [];
            foreach ($preparedSearch as $s) {
                $searchConstraints[] = $query->like('title', '%' . $s . '%');
                $searchConstraints[] = $query->like('subtitle', '%' . $s . '%');
            }
            if (!empty($searchConstraints)) {
                $constraints[] = $query->logicalOr($searchConstraints);
            }
        }
    
        // Zusätzliche Filter
        if (!empty($color)) {
            $constraints[] = $query->equals('color', $color);
        }
        if (!empty($origin)) {
            $constraints[] = $query->like('origin', '%' . $origin . '%');
        }
    
        // Anwenden der Constraints
        if (!empty($constraints)) {
            if (count($constraints) == 1) {
                $query->matching($constraints[0]); // Direkt das einzelne Constraint verwenden
            } else {
                $query->matching($query->logicalAnd(...$constraints)); // `logicalAnd` verwenden mit Spread Operator
            }
        }
    
        $query->setLimit((int)$limit);
        if ($offset > 0) {
            $query->setOffset((int)$offset);
        }
    
        return $query->execute();
    }
    
}
