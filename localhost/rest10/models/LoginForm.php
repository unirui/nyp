<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace app\models;
use yii\base\Model;
/**
 * Description of LoginForm
 *
 * @author sidzi
 */

class LoginForm extends Model {
   public $password;
   public $username;
   private $_user = false;
   
   public function rules() {
       return [
           [['username', 'password'], 'required'],
           ['password', 'validatePassword'],
           ];
   }
   
   public function validatePassword($attribute,$params) {
       if (!$this->hasErrors()) {
           $user = $this->getUser();
           if (!$user || !$user->validatePassword($this->password)) {
               $this->addError($attribute, 'Incorrect username or password.');
}
}
   }
   
   public function auth() {
      if ($this->validate()) {
          $this->_user->generateToken(time() + 3600 * 24);
          return $this->_user->save(false) ? $this->_user->
                  tokenInfo() : null;
          
      } else {
          return null;
} 
   }
   
   public function getUser() {
       if ($this->_user === false) {
           $this->_user = User::findByUsername($this->username);
           
       }
       return $this->_user;
   }
}
