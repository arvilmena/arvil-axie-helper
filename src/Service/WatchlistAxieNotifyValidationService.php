<?php
/**
 * WatchlistAxieNotifyValidationService.php file summary.
 *
 * WatchlistAxieNotifyValidationService.php file description.
 *
 * @link       https://project.com
 *
 * @package    Project
 *
 * @subpackage App\Service
 *
 * @author     Arvil Meña <arvil@arvilmena.com>
 *
 * @since      1.0.0
 */

declare(strict_types=1);

namespace App\Service;

use App\Entity\Axie;
use App\Entity\MarketplaceWatchlist;
use App\Repository\AxieRepository;
use App\Repository\MarketplaceWatchlistRepository;

/**
 * Class WatchlistAxieNotifyValidationService.
 *
 * Class WatchlistAxieNotifyValidationService description.
 *
 * @since 1.0.0
 */
class WatchlistAxieNotifyValidationService
{

    public function isWatchlistAllowed(MarketplaceWatchlist $watchlist, Axie $axie, $price) : bool {

        // check "price"
        if ( null !== $watchlist->getNotifyPrice() && (float) $price > $watchlist->getNotifyPrice()) {
            return false;
        }

        // check "exclude_when_zero_energy_card_gte"
        if (
            null !== $watchlist->getExcludeWhenZeroEnergyCardGte()
            && null !== $axie->getNumberOfZeroEnergyCard()
            && $axie->getNumberOfZeroEnergyCard() >= $watchlist->getExcludeWhenZeroEnergyCardGte()
        ) {
            return false;
        }

        // check "exclude_when_sum_of_energy_lte"
        if (
            null !== $watchlist->getExcludeWhenSumOfEnergyLte()
            && null !== $axie->getSumOfCardEnergy()
            && $axie->getSumOfCardEnergy() <= $watchlist->getExcludeWhenSumOfEnergyLte()
        ) {
            return false;
        }

        // check "exclude_avg_atk_per_card_lte"
        if (
            null !== $watchlist->getExcludeAvgAtkPerCardLte()
            && null !== $axie->getAvgAttackPerCard()
            && $axie->getAvgAttackPerCard() <= $watchlist->getExcludeAvgAtkPerCardLte()
        ) {
            return false;
        }

        // check "exclude_freaks_quality_lte"
        if (
            null !== $axie->getQuality()
            && null !== $watchlist->getExcludeFreaksQualityLte()
            && (float) $axie->getQuality() <= $watchlist->getExcludeFreaksQualityLte()) {
            return false;
        }

        return true;

    }

}
