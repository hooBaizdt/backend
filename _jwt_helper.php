<?php

class JWTAuth
{
    /**
     * Set the custom claims.
     *
     * @param  array $customClaims
     *
     * @return static
     */
    public static function customClaims(array $customClaims)
    {
        return \Tymon\JWTAuth\JWT::customClaims($customClaims);
    }

    /**
     * Alias to set the custom claims.
     *
     * @param  array  $customClaims
     *
     * @return static
     */
    public static function claims(array $customClaims)
    {
        return \Tymon\JWTAuth\JWT::claims($customClaims);
    }

    /**
     * Get the custom claims.
     *
     * @return array
     */
    public static function getCustomClaims()
    {
        return \Tymon\JWTAuth\JWT::getCustomClaims();
    }

    /**
     * Generate a token for a given subject.
     *
     * @param  \Tymon\JWTAuth\Contracts\JWTSubject  $subject
     *
     * @return string
     */
    public static function fromSubject(\Tymon\JWTAuth\Contracts\JWTSubject $subject)
    {
        return \Tymon\JWTAuth\JWT::fromSubject($subject);
    }

    /**
     * Alias to generate a token for a given user.
     *
     * @param  \Tymon\JWTAuth\Contracts\JWTSubject  $user
     *
     * @return string
     */
    public static function fromUser(\Tymon\JWTAuth\Contracts\JWTSubject $user)
    {
        return \Tymon\JWTAuth\JWT::fromSubject($user);
    }

    /**
     * Refresh an expired token.
     *
     * @param  bool  $forceForever
     * @param  bool  $resetClaims
     *
     * @return string
     */
    public static function refresh($forceForever = false, $resetClaims = false)
    {
        return \Tymon\JWTAuth\JWT::refresh($forceForever, $resetClaims);
    }

    /**
     * Invalidate a token (add it to the blacklist).
     *
     * @param  bool  $forceForever
     *
     * @return static
     */
    public static function invalidate($forceForever = false)
    {
        return \Tymon\JWTAuth\JWTAuth::invalidate($forceForever);
    }

    /**
     * Alias to get the payload, and as a result checks that
     * the token is valid i.e. not expired or blacklisted.
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     *
     * @return \Tymon\JWTAuth\Payload
     */
    public static function checkOrFail()
    {
        return \Tymon\JWTAuth\JWT::checkOrFail();
    }

    /**
     * Check that the token is valid.
     *
     * @param  bool  $getPayload
     *
     * @return \Tymon\JWTAuth\Payload|bool
     */
    public static function check($getPayload = false)
    {
        return \Tymon\JWTAuth\JWT::check($getPayload);
    }

    /**
     * Get the token.
     *
     * @return \Tymon\JWTAuth\Token|false
     */
    public static function getToken()
    {
        return \Tymon\JWTAuth\JWT::getToken();
    }

    /**
     * Parse the token from the request.
     *
     * @throws \Tymon\JWTAuth\Exceptions\JWTException
     *
     * @return static
     */
    public static function parseToken()
    {
        return \Tymon\JWTAuth\JWT::parseToken();
    }

    /**
     * Get the raw Payload instance.
     *
     * @return \Tymon\JWTAuth\Payload
     */
    public static function getPayload()
    {
        return \Tymon\JWTAuth\JWT::getPayload();
    }

    /**
     * Alias for getPayload().
     *
     * @return \Tymon\JWTAuth\Payload
     */
    public static function payload()
    {
        return \Tymon\JWTAuth\JWT::payload();
    }

    /**
     * Convenience method to get a claim value.
     *
     * @param  string  $claim
     *
     * @return mixed
     */
    public static function getClaim($claim)
    {
        return \Tymon\JWTAuth\JWT::getClaim($claim);
    }

    /**
     * Create a Payload instance.
     *
     * @param  \Tymon\JWTAuth\Contracts\JWTSubject  $subject
     *
     * @return \Tymon\JWTAuth\Payload
     */
    public static function makePayload(\Tymon\JWTAuth\Contracts\JWTSubject $subject)
    {
        return \Tymon\JWTAuth\JWT::makePayload($subject);
    }

    /**
     * Check if the provider matches the one saved in the token.
     *
     * @param  string|object  $provider
     *
     * @return bool
     */
    public static function checkProvider($provider)
    {
        return \Tymon\JWTAuth\JWT::checkProvider($provider);
    }

    /**
     * Set the token.
     *
     * @param  \Tymon\JWTAuth\Token|string $token
     *
     * @return $this
     */
    public static function setToken($token)
    {
        return \Tymon\JWTAuth\JWT::setToken($token);
    }

    /**
     * Unset the current token.
     *
     * @return static
     */
    public static function unsetToken()
    {
        return \Tymon\JWTAuth\JWT::unsetToken();
    }

    /**
     * Set the request instance.
     *
     * @param  \Illuminate\Http\Request  $request
     *
     * @return static
     */
    public static function setRequest(\Illuminate\Http\Request $request)
    {
        return \Tymon\JWTAuth\JWT::setRequest($request);
    }

    /**
     * Get the Manager instance.
     *
     * @return \Tymon\JWTAuth\Manager
     */
    public static function manager()
    {
        return \Tymon\JWTAuth\JWT::manager();
    }

    /**
     * Get the Parser instance.
     *
     * @return \Tymon\JWTAuth\Http\Parser\Parser
     */
    public static function parser()
    {
        return \Tymon\JWTAuth\JWT::parser();
    }

    /**
     * Get the Payload Factory.
     *
     * @return \Tymon\JWTAuth\Factory
     */
    public static function factory()
    {
        return \Tymon\JWTAuth\JWT::factory();
    }

    /**
     * Get the Blacklist.
     *
     * @return \Tymon\JWTAuth\Blacklist
     */
    public static function blacklist()
    {
        return \Tymon\JWTAuth\JWT::blacklist();
    }

    /**
     * Attempt to authenticate the user and return the token.
     *
     * @param  array  $credentials
     *
     * @return false|string
     */
    public static function attempt(array $credentials)
    {
        return \Tymon\JWTAuth\JWTAuth::attempt($credentials);
    }

    /**
     * Authenticate a user via a token.
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject|false
     */
    public static function authenticate()
    {
        return \Tymon\JWTAuth\JWTAuth::authenticate();
    }

    /**
     * Alias for authenticate().
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject|false
     */
    public static function toUser()
    {
        return \Tymon\JWTAuth\JWTAuth::toUser();
    }

    /**
     * Get the authenticated user.
     *
     * @return \Tymon\JWTAuth\Contracts\JWTSubject
     */
    public static function user()
    {
        return \Tymon\JWTAuth\JWTAuth::user();
    }
}