<?php
/**
 * NotifyService.php file summary.
 *
 * NotifyService.php file description.
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
use Symfony\Component\Mailer\Exception\TransportExceptionInterface;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;

/**
 * Class NotifyService.
 *
 * Class NotifyService description.
 *
 * @since 1.0.0
 */
class NotifyService
{

    /**
     * @var MailerInterface
     */
    private $mailer;

    public function __construct(MailerInterface $mailer)
    {

        $this->mailer = $mailer;
    }

    public function test($msg) {

        $output = [
            'error' => true,
            'msg' => ''
        ];

        if (empty($msg)) {
            $html = 'this is just a test';
        } else {
            $html = $msg;
        }

        $email = (new Email())
            ->from('my-axie-helper@arvilmena.com')
            ->to('arvil@arvilmena.com')
            ->subject($html)
            ->html($html);

        try {
            $this->mailer->send($email);
            $output['msg'] = false;
        } catch (TransportExceptionInterface $e) {
            $output['msg'] = $e->getMessage();
        }
        return $output;
    }

    /**
     * @param Axie[] $axies
     */
    public function notifyPriceAlert(array $axies, MarketplaceWatchlist $watchlist = null) {


        $output = [
            'error' => true,
            'msg' => ''
        ];

        $html = '';

        if ($watchlist instanceof MarketplaceWatchlist) {
            $html .= 'Price hit for watchlist: ' . $watchlist->getId() . ' - ' . $watchlist->getName() . ' pricelimit: ' . $watchlist->getNotifyPrice() . '<br />';
        }

        $html .= '<ul>';
        foreach ($axies as $axie) {
            $html .= '<li><a href="' .  $axie->getUrl(). '">' . $axie->getId() . '</a></li>';
        }
        $html .= '</ul>';

        $email = (new Email())
            ->from('my-axie-helper@arvilmena.com')
            ->to('arvil@arvilmena.com')
            ->subject('[PRICE ALERT AXIES] ' . count( $axies ) . ' axies hit the price limit')
            ->html($html);

        try {
            $this->mailer->send($email);
            $output['msg'] = false;
        } catch (TransportExceptionInterface $e) {
            $output['msg'] = $e->getMessage();
        }
        return $output;
    }

}
