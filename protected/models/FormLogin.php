<?php

/**
 * LoginForm class.
 * LoginForm is the data structure for keeping
 * user login form data. It is used by the 'login' action of 'SiteController'.
 */
class FormLogin extends FormModel
{
    const ACTION_REGISTER = 'register';
    const ACTION_LOGIN = 'login';
    const ACTION_CHECK = 'check';

    public $email;
    public $password;
    public $password_new;
    public $password_repeat;

    /**
     * Declares the validation rules.
     * The rules state that username and password are required,
     * and password needs to be authenticated.
     */
    public function rules()
    {
        return [
            ['email', 'email', 'allowEmpty' => false, 'message' => 'You should enter correct email address'],
            // Login rules
            ['password', 'required', 'on' => self::ACTION_LOGIN, 'message' => 'Please, enter your password'],
            ['email, password', 'authenticate', 'on' => self::ACTION_LOGIN],
            // Register rules
            [
                'email',
                'unique',
                'on'            => self::ACTION_REGISTER,
                'className'     => 'Users',
                'attributeName' => 'email',
                'caseSensitive' => true,
                'message'       => 'Sorry, but this email already taken!'
            ],
            ['password_new', 'required', 'on' => self::ACTION_REGISTER, 'message' => 'Please, enter your password'],
            ['password_repeat', 'required', 'on' => self::ACTION_REGISTER, 'message' => 'You should confirm your password!'],
            [
                'password_new',
                'compare',
                'compareAttribute' => 'password_repeat',
                'on'               => self::ACTION_REGISTER,
                'message'          => 'Passwords do not match!'
            ],
        ];
    }

    /**
     * Authenticates the password.
     * This is the 'authenticate' validator as declared in rules().
     */
    public function authenticate($attribute, $params)
    {
        if ( !$this->hasErrors()) {
            $identity = new Identity($this->email, $this->password);
            if ( !$identity->authenticate()) {
                $this->addError('password', 'Incorrect username or password.');
            }
        }
    }

    /**
     * Register new user
     */
    public function register()
    {
        if ( !is_null(Users::findUserByEmail($this->email))) {
            $this->addError('email', 'Sorry, but this email already taken');
            return false;
        }

        $user = Users::register($this->email, $this->password_new);

        $identity = new Identity($user->email, $this->password_new);
        $identity->authenticate();
        return true;
    }
}
