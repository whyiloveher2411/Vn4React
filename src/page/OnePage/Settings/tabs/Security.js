import { Collapse, Divider, Grid, IconButton, InputAdornment, Typography } from '@material-ui/core';
import RefreshIcon from '@material-ui/icons/Refresh';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import FieldForm from 'components/FieldForm';
import { Skeleton } from '@material-ui/lab';
import { __ } from 'utils/i18n';
import _ from 'lodash';


function Security({ post, onReview }) {

    const [activeCapcha, setActiveCapcha] = React.useState(post.security_active_recapcha_google * 1 === 1);
    const [securityGoogleAuthenticatorSecret, setSecurityGoogleAuthenticatorSecret] = React.useState(post.security_google_authenticator_secret);
    const [securityGoogleAuthenticatorSecretImg, setSecurityGoogleAuthenticatorSecretImg] = React.useState(post.security_google_authenticator_secret_img);
    const [activeTwoLayerAuthenticator, setActiveTwoLayerAuthenticator] = React.useState(post.security_active_google_authenticator * 1 === 1);
    const [activeSignInWithGoogle, setActiveSignInWithGoogle] = React.useState(post.security_active_signin_with_google_account * 1 === 1);

    const { ajax } = useAjax();

    const randomGoogleAuthenticatorSecret = () => {
        ajax({
            url: 'settings/random-google-authenticator-secret',
            method: 'POST',
            success: (result) => {
                if (result.secret) {
                    setSecurityGoogleAuthenticatorSecret(result.secret); onReview(result.secret, 'security_google_authenticator_secret');
                    setSecurityGoogleAuthenticatorSecretImg(result.qrCodeUrl); onReview(result.qrCodeUrl, 'security_google_authenticator_secret_img');
                }
            }
        });
    }

    React.useEffect(() => {

        if (securityGoogleAuthenticatorSecretImg) {

        }

    }, [securityGoogleAuthenticatorSecretImg]);

    return (
        <>
            <Grid
                container
                spacing={4}>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'text'}
                        config={{
                            title: __('Link to admin page'),
                            note: __('The default admin page path is admin, change it to a secret word that only you and a few people know to be able to access the webmaster')
                        }}
                        post={post}
                        name={'security_prefix_link_admin'}
                        onReview={value => onReview(value, 'security_prefix_link_admin')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'text'}
                        config={{
                            title: 'Link Sign In',
                        }}
                        post={post}
                        name={'security_link_login'}
                        onReview={value => onReview(value, 'security_link_login')}
                    />
                </Grid>
                <Divider style={{ width: '100%', margin: '24px 0' }} />
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'number'}
                        config={{
                            title: __('Token expiration time (Seconds)'),
                            note: __('Default is 3600 seconds'),
                        }}
                        post={post}
                        name={'security_token_expiration_time'}
                        onReview={value => onReview(value, 'security_token_expiration_time')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'number'}
                        config={{
                            title: __('Limit the number of times you enter the wrong password'),
                        }}
                        post={post}
                        name={'security_limit_login_count'}
                        onReview={value => onReview(value, 'security_limit_login_count')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'number'}
                        config={{
                            title: __('Waiting time after entering wrong password too many times'),
                        }}
                        post={post}
                        name={'security_limit_login_time'}
                        onReview={value => onReview(value, 'security_limit_login_time')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'textarea'}
                        config={{
                            title: __('Limit ip can login admin page'),
                        }}
                        post={post}
                        name={'security_accept_ip_login'}
                        onReview={value => onReview(value, 'security_accept_ip_login')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'select'}
                        config={{
                            title: __('Sign in on a single machine'),
                            list_option: {
                                0: { title: __('Optional'), description: __('User may not enable or enable it depending on the user') },
                                1: { title: __('Obligatory'), description: __('All users are only allowed to login on a single machine at a time') }
                            }
                        }}
                        post={post}
                        name={'security_accept_ip_login'}
                        onReview={value => onReview(value, 'security_accept_ip_login')}
                    />
                </Grid>
                <Divider style={{ width: '100%', margin: '24px 0' }} />
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: __('Disable Iframe'),
                            note: __('Turn off embedding my website on other websites'),
                        }}
                        post={post}
                        name={'security_disable_iframe'}
                        onReview={value => onReview(value, 'security_disable_iframe')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: __('Sign In on one device'),
                            note: __('Only one device login limit'),
                        }}
                        post={post}
                        name={'security_login_on_a_single_machine'}
                        onReview={value => onReview(value, 'security_login_on_a_single_machine')}
                    />
                </Grid>
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: __('Enable Remember Me'),
                            note: __('User will not need to sign in after each token expiration, this function is usually used with personal computers'),
                        }}
                        post={post}
                        name={'security_enable_remember_me'}
                        onReview={value => onReview(value, 'security_enable_remember_me')}
                    />
                </Grid>
                <Divider style={{ width: '100%', margin: '24px 0' }} />
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: __('Activate Recaptcha'),
                            note: __('Enable captcha checking in the login form into the admin area'),
                        }}
                        post={post}
                        name={'security_active_recapcha_google'}
                        onReview={value => { setActiveCapcha(value); onReview(value, 'security_active_recapcha_google') }}
                    />
                </Grid>
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%' }} in={Boolean(activeCapcha)}>
                    <Grid
                        style={{ marginBottom: 8 }}
                        container
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: __('Site Key Recapcha Google'),
                                    note: __('Site Key Recapcha Google is the key capcha of your website used to authenticate recapcha used on login, you can get the key here . learn more here'),
                                }}
                                post={post}
                                name={'security_recaptcha_sitekey'}
                                onReview={value => onReview(value, 'security_recaptcha_sitekey')}
                            />
                        </Grid>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: __('Recapcha secret'),
                                    note: __('Recapcha secret is the capcha code of your website used to authenticate recapcha used on login, you can get the key here . learn more <a href="https://www.google.com/recaptcha/admin" target="_blank"> here </a>'),
                                }}
                                post={post}
                                name={'security_recaptcha_secret'}
                                onReview={value => onReview(value, 'security_recaptcha_secret')}
                            />
                        </Grid>
                    </Grid>
                </Collapse>
                <Divider style={{ width: '100%', margin: '24px 0' }} />
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: __('2-Step Authentication'),
                        }}
                        post={post}
                        name={'security_active_google_authenticator'}
                        onReview={value => { setActiveTwoLayerAuthenticator(value); onReview(value, 'security_active_google_authenticator') }}
                    />
                </Grid>
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%' }} in={Boolean(activeTwoLayerAuthenticator)}>
                    <Grid
                        style={{ marginBottom: 8 }}
                        container
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: __('Google Authenticator Secret'),
                                    note: __('Scan the image below with Google Authenticator or an alternative application.')
                                }}
                                endAdornment={
                                    <InputAdornment position="end">
                                        <IconButton
                                            aria-label="random Google Authenticator Secret"
                                            edge="end"
                                            onClick={randomGoogleAuthenticatorSecret}
                                            onMouseDown={(e) => { e.preventDefault(); }}
                                        >
                                            <RefreshIcon />
                                        </IconButton>
                                    </InputAdornment>
                                }
                                post={{ security_google_authenticator_secret: securityGoogleAuthenticatorSecret }}
                                name={'security_google_authenticator_secret'}
                                onReview={value => { setSecurityGoogleAuthenticatorSecret(value); onReview(value, 'security_google_authenticator_secret'); }}
                            />
                            {
                                Boolean(securityGoogleAuthenticatorSecretImg) ?
                                    <img alt="QR Code" style={{ marginTop: 8 }} src={securityGoogleAuthenticatorSecretImg} />
                                    :
                                    <Skeleton style={{ width: 200, height: 200, marginTop: 8, transform: 'scale(1, 1)' }} />
                            }
                        </Grid>
                    </Grid>
                </Collapse>
                <Divider style={{ width: '100%', margin: '24px 0' }} />
                <Grid item md={12} xs={12} >
                    <FieldForm
                        compoment={'true_false'}
                        config={{
                            title: __('Sign In With Google'),
                            note: __('Accounts using google email will be mapped to google accounts to help you sign in faster and more securely (registration not included).'),
                        }}
                        post={post}
                        name={'security_active_signin_with_google_account'}
                        onReview={value => { setActiveSignInWithGoogle(value); onReview(value, 'security_active_signin_with_google_account') }}
                    />
                </Grid>
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%' }} in={Boolean(activeSignInWithGoogle)}>
                    <Grid
                        container
                        style={{ marginBottom: 8 }}
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: __('Google OAuth Client ID'),
                                }}
                                post={post}
                                name={'security_google_oauth_client_id'}
                                onReview={value => onReview(value, 'security_google_oauth_client_id')}
                            />
                        </Grid>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: __('Google OAuth Client Secret'),
                                }}
                                post={post}
                                name={'security_google_oauth_client_secret'}
                                onReview={value => onReview(value, 'security_google_oauth_client_secret')}
                            />
                        </Grid>
                    </Grid>
                </Collapse>
            </Grid>
        </>
    )
}

export default Security
