<?php
use Spatie\Permission\Models\Role;

Role::create(['name' => 'admin']);
Role::create(['name' => 'manager']);
Role::create(['name' => 'employee']);
