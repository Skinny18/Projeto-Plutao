<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 *
 * @property-read User|null $user
 *
 */
class LoginForm extends Model
{

    public $username;
    public $password_hash;
    public $rememberMe = true;

    private $_user = false;

    public static function tableName()
    {
        return 'users';
    }


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // username and password are both required
            [['username', 'password_hash'], 'required'],
            // rememberMe must be a boolean value
            // password is validated by validatePassword()
            ['password_hash', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
       
        $user = $this->getUser();
        
        if ($user && Yii::$app->getSecurity()->validatePassword($this->password_hash, $user->password_hash)) {
 
            return true;
        }
        $this->addError('password', 'Incorrect username or password.');
        return false;

    }

    /**
     * Logs in a user using the provided username and password.
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
           
            return Yii::$app->user->login($this->getUser(), $this->rememberMe ? 3600 * 24 * 30 : 0);
                }
        return false;
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    public function getUser()
    {
        if ($this->_user === false) {
            
            $this->_user = User::findOne(['username' => $this->username]);
        }
        return $this->_user;    
    }
}
