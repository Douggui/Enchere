<?php
namespace App\Enum;



enum AuctionStatus: string {

    case Dispanible = 'disponible';
    case StandBy = 'StandBy';
    case Visible = 'Visible';
    case Archived = 'Archived';
    case Canceled = 'Canceled';

   
    
}