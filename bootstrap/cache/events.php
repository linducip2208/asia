<?php return array (
  'App\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\OrderCompleted' => 
    array (
      0 => 'App\\Listeners\\CreateOrderJournalEntry',
      1 => 'App\\Listeners\\UpdateLoyaltyAndStock',
    ),
  ),
  'Illuminate\\Foundation\\Support\\Providers\\EventServiceProvider' => 
  array (
    'App\\Events\\OrderCompleted' => 
    array (
      0 => 'App\\Listeners\\CreateOrderJournalEntry@handle',
      1 => 'App\\Listeners\\UpdateLoyaltyAndStock@handle',
    ),
  ),
);