<?php

namespace App\Contract;

enum ExpireMode: string
{
  case READ_ONE_TIME = "READ_ONE_TIME";
  case AT_CONFIGURED_TIME =  "AT_CONFIGURED_TIME";
}
