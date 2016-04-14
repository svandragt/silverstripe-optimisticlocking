<?php
class OptimisticLocking extends DataExtension
{
    public function __construct()
    {
        parent::__construct();
        DataObject::set_validation_enabled(true);
    }

    public static $db = array(
        'OLToken' => 'Int', # optimistic locking
    );

    public function onBeforeWrite()
    {
        // update token, as validation passes
        $this->owner->OLToken = SS_Datetime::now()->Format('U');
        parent::onBeforeWrite();
    }


    public function validate(ValidationResult $validationResult)
    {
        if ($this->owner->ID >0 && $this->hasTokenChanged()) {
            $validationResult->combineAnd(
                new ValidationResult(false, _t('OptimisticLocking.NOSAVEREFRESH',
                "Save aborted as information has changed. Please refresh the page and try again.",
                'User tried to save the dataobject but it had changed since they started working on it.')
            ));
        }
        return $validationResult;
    }


    public function hasTokenChanged()
    {
        // user_error if OLToken != database OLtoken: changes
        $dbOLToken = DataObject::get_by_id($this->owner->ClassName, $this->owner->ID, false)->OLToken;
        return ($this->owner->OLToken !== $dbOLToken);
    }

    public function getCMSFields()
    {
        $fields = parent::getCMSFields();
        $this->extend('updateCMSFields', $fields);
        return $fields;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('OLToken');
        $fields->push(new HiddenField('OLToken', false));
    }
}
