<?php

namespace app\models;
use yii\web\IdentityInterface;
class User extends  \yii\db\ActiveRecord implements IdentityInterface
{    
    
    

    public static function tableName()
    {
        return 'users';
    }

    public function rules()
    {
        return [
            [['username', 'email', 'password_hash'], 'required'],
            ['email', 'email'],
            [['limite_reservas'], 'integer'],
            [['username', 'email'], 'unique'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Usuário',
            'email' => 'E-mail',
            'password_hash' => 'Senha',
            'auth_key' => 'Auth Key',
        ];
    }



    /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
       
        return static::findOne(['id' => $id]);
    }

    /**
     * {@inheritdoc}
     */

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername()
    {
        
        return static::findOne(['username' => 'username']);
    }

    /**
     * {@inheritdoc}
     * 
     * 
     * 
     * 
     */

     public static function findIdentityByAccessToken($token, $type = null)
     {
         return static::findOne(['access_token' => $token]);
     }

    public function getUser()
    {
        return $this->username;
    }

    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

  


    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        
        return $this->password_hash === $password;
    }


    
}
