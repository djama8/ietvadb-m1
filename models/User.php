<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property int $id
 * @property string $name
 * @property string $firstname
 * @property string $patronimyc
 * @property int $phone
 * @property string $email
 * @property string $username
 * @property string $password
 *
 * @property Request[] $requests
 */
class User extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'firstname', 'patronimyc', 'phone', 'email', 'username', 'password'], 'required'],
            [['phone'], 'integer'],
            [['name', 'firstname', 'patronimyc', 'email', 'username', 'password'], 'string', 'max' => 255],
            [['password'], 'string', 'min' => 6],
            [['name', 'firstname', 'patronimyc'], 'match', 'pattern'=>"/[а-яёА-ЯЁ]/u", 'message'=> 'Только на русском'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'firstname' => 'Фамилия',
            'patronimyc' => 'Отчество',
            'phone' => 'Телефон',
            'email' => 'Почта',
            'username' => 'Логин',
            'password' => 'Пароль',
        ];
    }

    /**
     * Gets query for [[Requests]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRequests()
    {
        return $this->hasMany(Request::class, ['id_user' => 'id']);
    }



    //Регистрация 


       /**
     * {@inheritdoc}
     */
    public static function findIdentity($id)
    {
       return self::findOne($id);
    }

    /**
     * {@inheritdoc}
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }

        return null;
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return self::find()->where(['username'=>$username])->one();
    }

    /**
     * {@inheritdoc}
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * {@inheritdoc}
     */
    public function getAuthKey()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function validateAuthKey($authKey)
    {
        
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return bool if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === $password;
    }
}
