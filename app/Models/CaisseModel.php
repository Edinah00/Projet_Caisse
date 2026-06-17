<?php
namespace App\Models;
use CodeIgniter\Model;

class CaisseModel extends Model
{
    protected $table = 'caisse';
    protected $primaryKey = 'id';
    protected $allowedFields = ['numero', 'localisation'];
}