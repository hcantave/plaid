<?php

namespace Hcantave\Plaid\Entities;

class AccountFilters
{
    /**
     * AccountFilters constructor.
     *
     * @param  array<string,array<string>>  $filters
     */
    public function __construct(protected array $filters = [])
    {
        foreach ($filters as $name => $subtypes) {
            $this->setFilter($name, $subtypes);
        }
    }

    /**
     * Set filters for the given type.
     *
     * @param  array<string>  $subtypes
     */
    protected function setFilter(string $type, array $subtypes): void
    {
        if (empty($subtypes)) {
            return;
        }

        $this->filters[$type] = ['account_subtypes' => $subtypes];
    }

    /**
     * Set depository subtype filters.
     *
     * Possible subtypes are:
     *	auth
     *	transactions
     *	identity
     *	income
     *	assets
     *	all
     *
     * @param  array<string>  $subtypes
     */
    public function setDepositoryFilters(array $subtypes): void
    {
        $this->setFilter('depository', $subtypes);
    }

    /**
     * Set credit filters.
     *
     * Possible subtypes are:
     *	transactions
     *	identity
     * 	liabilities
     *	all
     *
     * @param  array<string>  $subtypes
     */
    public function setCreditFilters(array $subtypes): void
    {
        $this->setFilter('credit', $subtypes);
    }

    /**
     * Set investment filters.
     *
     * Possible subtypes are:
     * 	investment
     * 	all
     *
     * @param  array<string>  $subtypes
     */
    public function setInvestmentFilters(array $subtypes): void
    {
        $this->setFilter('investment', $subtypes);
    }

    /**
     * Set loan filters.
     *
     * Possible values are:
     * 	transactions
     * 	liabilities
     * 	all
     *
     * @param  array<string>  $subtypes
     */
    public function setLoanFilters(array $subtypes): void
    {
        $this->setFilter('loan', $subtypes);
    }

    /**
     * Set other filters.
     *
     * Possible values are:
     * 	auth
     * 	transactions
     * 	identity
     * 	assets
     *	all
     *
     * @param  array<string>  $subtypes
     */
    public function setOtherFilters(array $subtypes): void
    {
        $this->setFilter('other', $subtypes);
    }

    /**
     * Get all filters as array.
     *
     * @return array<string,array<string,array<string>>>
     */
    public function toArray(): array
    {
        return $this->filters;
    }
}
