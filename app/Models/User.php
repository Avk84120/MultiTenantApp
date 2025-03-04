<?php
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    use HasRoles;
}
