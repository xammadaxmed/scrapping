<?php

namespace App\Models;

use CodeIgniter\Model;

class DbContext extends Model
{
    public Organization $Organizations;
    public Person $Persons;
    public Configuration $Configurations;
    public Lists $Lists;
    public ListTemplate $ListTemplates;
    public ListTemplateDetails $ListTemplateDetails;
    public Title $Titles;
    public function __construct()
    {
        $this->Persons = new Person();
        $this->Configurations = new Configuration();
        $this->Organizations = new Organization();
        $this->Lists = new Lists();
        $this->ListTemplates = new ListTemplate();
        $this->ListTemplateDetails = new ListTemplateDetails();
        $this->Titles = new Title();
    }

    public static function create()
    {
        return new DbContext();
    }

    public function getDomainColumn()
    {
       return $this->Configurations->get('DOMAIN_COLUMN');
    }
}
