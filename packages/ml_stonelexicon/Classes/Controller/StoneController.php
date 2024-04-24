<?php
declare(strict_types=1);

// StoneController.php
// Controller für die Ausgabe der Listenansicht der Steine in der Gruppen mit der Suche nach Farbe, Herkunft, Suchwort

namespace Simplesigns\MlStonelexicon\Controller;

use TYPO3\CMS\Extbase\Persistence\QueryResultInterface;
use Psr\Http\Message\ResponseInterface;
use Simplesigns\MlStonelexicon\Domain\Repository\PageRepository;
use TYPO3\CMS\Extbase\Mvc\Controller\ActionController;

class StoneController extends ActionController
{
    /**
     * @var PageRepository
     */
    protected $pageRepository = null;

    public function __construct(PageRepository $pageRepository)
    {
        $this->pageRepository = $pageRepository;
    }

    /**
     * Initialisiert die List-Action.
     */
    protected function initializeListAction(): void
    {
    }

    /**
     * Zeigt eine Liste aller Steine an.
     *
     * @return ResponseInterface
     */
    public function listAction(): ResponseInterface
    {
        $this->contentObj = $this->request->getAttribute('currentContentObject');

        $storagePids = explode(',', $this->contentObj->data['pages'] ?? '');
        $this->view->assign('pid', (int)($this->contentObj->data['pages'] ?? ''));

        $stones = $this->pageRepository->findAll($storagePids);

        $this->view->assign('pageTitle', $GLOBALS['TSFE']->page['title']);

        // initialisiert $filterArray
        $filterArray = static::getFilterArray($stones);

        $this->view->assign('allOrigins', $filterArray['origin'] ?? []);
        $this->view->assign('allColors', $filterArray['color'] ?? []);
        $this->view->assign('allSearchWords', $filterArray['searchWord'] ?? []);
        $this->view->assign('stones', $stones);

        return $this->htmlResponse();
    }

    /**
     * Sucht nach Steinen basierend auf Farbe, Materialname und Abbauort.
     *
     * @param string|null $searchColor
     * @param string|null $searchString
     * @param string|null $searchOrigin
     * @param string|null $resetSearch
     * @param string|null $pid
     */
    public function searchAction(?string $searchColor = null, ?string $searchString = null, ?string $searchOrigin = null, ?string $resetSearch = null, ?string $pid = null): void
    {
        $this->contentObj = $this->request->getAttribute('currentContentObject');

        if ($pid !== null) {
            $storagePids = explode(',', $pid);
            $this->view->assign('pid', $pid);
        } elseif ($this->contentObj->data['pages'] !== '') {
            $storagePids = explode(',', $this->contentObj->data['pages']);
        }

        $storagePidsForFilter = [];

        if (!empty($resetSearch)) {
            $this->clearSearchSession();

            $uriBuilder = $this->uriBuilder;
            $uri = $uriBuilder
                ->setTargetPageUid((int)$pid)
                ->build();
            $this->redirectToURI($uri, $delay = 0);
            return;
        } else {
            // Entfernen Sie die vorherige Suche aus dem FilterArray
            $filterArray = ['origin' => [], 'color' => [], 'searchWord' => []];

            $stones = $this->pageRepository->findByFilter($storagePids, $searchString, $searchColor, $searchOrigin);

            if ($searchString !== null) {
                $stonesWithSearchString = $this->pageRepository->findByFilter($storagePids, $searchString, null, null);
                $filterArray = static::getFilterArray($stonesWithSearchString);
            } else {
                $filterArray = static::getFilterArray($stones);
            }

            if ($stones) {
                foreach ($stones as $stone) {
                    $storagePidsForFilter[] = strval($stone->getUid());
                }
            }
        }

        $this->view->assign('allOrigins', $filterArray['origin'] ?? []);
        $this->view->assign('allColors', $filterArray['color'] ?? []);
        $this->view->assign('allSearchWords', $filterArray['searchWord'] ?? []);

        if (!empty($searchOrigin)) {
            $this->view->assign('origin', $searchOrigin);
        }

        if (!empty($searchColor)) {
            $this->view->assign('searchColor', $searchColor);
        }
        if ($pid) {
            $searchTitle = $this->pageRepository->findByUid($pid);
            $this->view->assign('page', $searchTitle);
        }

        $this->view->assign('search', $searchString);
        $this->view->assign('stones', $stones);
    }

    /**
     * Generiert ein Array mit den verfügbaren Abbauorten und Suchbegriffen basierend auf den gefundenen Steinen.
     *
     * @param array|QueryResultInterface $stones
     * @return array
     */
    public static function getFilterArray($stones): array
    {
        $originArray = [];
        $colorArray = [];
        $searchWordArray = [];

        if ($stones instanceof QueryResultInterface) {
            foreach ($stones as $stone) {
                self::addToFilterArray($originArray, $stone->getOrigin());
                self::addToFilterArray($colorArray, $stone->getColor());
                self::addToFilterArray($searchWordArray, $stone->getTitle());
                self::addToFilterArray($searchWordArray, $stone->getSubtitle());
            }
        } elseif (is_array($stones)) {
            foreach ($stones as $stone) {
                self::addToFilterArray($originArray, $stone->getOrigin());
                self::addToFilterArray($colorArray, $stone->getColor());
                self::addToFilterArray($searchWordArray, $stone->getTitle());
                self::addToFilterArray($searchWordArray, $stone->getSubtitle());
            }
        }

        ksort($originArray);
        ksort($colorArray);
        ksort($searchWordArray);

        return [
            'origin' => $originArray,
            'color' => $colorArray,
            'searchWord' => $searchWordArray,
        ];
    }

    /**
     * Hilfsmethode zum Hinzufügen von Elementen zu einem Array, wenn der Wert nicht leer ist.
     *
     * @param array $array
     * @param string|int|null $value
     */
    private static function addToFilterArray(array &$array, $value): void
    {
        if ($value !== null && $value !== '') {
            $array[$value] = $value;
        }
    }

    /**
     * Leert die Suchsession.
     */
    public function clearSearchSession(): void
    {
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_ml_stonelexicon_widget_paginate_color', '');
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_ml_stonelexicon_widget_paginate_filter', '');
        $GLOBALS['TSFE']->fe_user->setKey('ses', 'tx_ml_stonelexicon_widget_paginate_origin', '');
        $GLOBALS['TSFE']->fe_user->storeSessionData();
    }
}
