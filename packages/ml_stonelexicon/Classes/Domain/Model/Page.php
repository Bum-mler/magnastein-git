<?php
declare(strict_types=1);

namespace Simplesigns\MlStonelexicon\Domain\Model;
// Page.php
use TYPO3\CMS\Extbase\Annotation as Extbase;
use TYPO3\CMS\Extbase\DomainObject\AbstractEntity;
use TYPO3\CMS\Extbase\Persistence\ObjectStorage;

class Page extends AbstractEntity
{
    /**
     * @var string
     */
    #[Extbase\Validate(['validator' => 'NotEmpty'])]
    protected string $title = '';

    /**
     * @var string
     */
    protected string $subtitle = '';

    /**
     * @var string
     */
    protected string $abstract = '';

    /**
     * @var string
     */
    protected string $rocktype = '';

    /**
     * @var string
     */
    protected string $subgroup = '';

    /**
     * @var string
     */
    protected string $age = '';

    /**
     * @var string
     */
    protected string $origin = '';

    /**
     * @var int
     */
    protected int $color = 0;

    /**
     * @var string
     */
    protected string $structure = '';

    /**
     * @var array
     */
    protected array $indoordry = [1 => 0, 2 => 0, 3 => 0, 4 => 0, 5 => 0];

    /**
     * @var array
     */
    protected array $indoorwet = [1 => 0, 2 => 0, 3 => 0];

    /**
     * @var array
     */
    protected array $outdoor = [1 => 0, 2 => 0, 3 => 0];

    // Getter methods

    public function getTitle(): string
    {
        return $this->title;
    }

    public function getSubtitle(): string
    {
        return $this->subtitle;
    }

    public function getAbstract(): string
    {
        return $this->abstract;
    }

    public function getRocktype(): string
    {
        return $this->rocktype;
    }

    public function getSubgroup(): string
    {
        return $this->subgroup;
    }

    public function getAge(): string
    {
        return $this->age;
    }

    public function getOrigin(): string
    {
        return $this->origin;
    }

    public function getColor(): int
    {
        return $this->color;
    }

    public function getStructure(): string
    {
        return $this->structure;
    }

    public function getIndoordry(): array
    {
        return $this->indoordry;
    }

    public function getIndoorwet(): array
    {
        return $this->indoorwet;
    }

    public function getOutdoor(): array
    {
        return $this->outdoor;
    }
    
    // Setter methods
    public function setStructure(string $structure): void
    {
        $this->structure = $structure;
    }

}
