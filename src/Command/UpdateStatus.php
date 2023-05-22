<?php
namespace App\Command;

use DateTime;
use App\Enum\AuctionStatus;
use App\Repository\AuctionRepository;
use Doctrine\ORM\EntityManagerInterface;
use phpDocumentor\Reflection\Types\Parent_;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Attribute\AsCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;


#[AsCommand(name: 'auctions:status:update')]
class UpdateStatus extends Command
{
    public function __construct
    (
        
        private AuctionRepository $auctionRepo,
        private EntityManagerInterface $manager,
    )
    {
        parent::__construct();
    }
    protected function execute(InputInterface $input, OutputInterface $output): int
    {

        $auctions = $this->auctionRepo->findBy(['status'=>AuctionStatus::StandBy]);
        $count = 0;
        foreach ($auctions as $auction) {
            
            $now = new DateTime();
            $openDate=$auction->getDateOpen();
            if( $now >= $openDate )
            {
                $count++;
                $auction->setStatus(AuctionStatus::Visible);
                $this->manager->persist($auction);

            }
        }
        
        $this->manager->flush();

        $output->writeln("<info> $count auction(s) ont été mis à jour</info>");
        // ... put here the code to create the user

        // this method must return an integer number with the "exit status code"
        // of the command. You can also use these constants to make code more readable

        // return this if there was no problem running the command
        // (it's equivalent to returning int(0))
        return Command::SUCCESS;

        // or return this if some error happened during the execution
        // (it's equivalent to returning int(1))
        // return Command::FAILURE;

        // or return this to indicate incorrect command usage; e.g. invalid options
        // or missing arguments (it's equivalent to returning int(2))
        // return Command::INVALID
    }
}