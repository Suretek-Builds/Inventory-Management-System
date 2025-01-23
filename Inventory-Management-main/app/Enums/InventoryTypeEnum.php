<?php

namespace App\Enums;

enum InventoryTypeEnum: string
{
    case ADDED = 'added_inventory';
    case DEDUCTED_FOR_PROCEDURE = 'deducted_for_procedure';
    case RESTOCK = 'restock_inventory';
    case ADJUSTED_PROCEDURE = 'adjusted_canceled_procedure';
}
