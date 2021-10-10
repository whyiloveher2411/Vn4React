import { Button, Grid, Hidden, IconButton, Typography } from '@material-ui/core';
import { makeStyles } from '@material-ui/core/styles';
import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { updatePlugins } from 'actions/plugins';
import { updateSidebar } from 'actions/sidebar';
import { login } from 'actions/user';
import { useAjax } from 'utils/useAjax';
import FieldForm from 'components/FieldForm';
import MobileFriendlyIcon from '@material-ui/icons/MobileFriendly';
import { useSnackbar } from 'notistack';
import { MaterialIcon } from 'components';
import { changeMode } from 'actions/viewMode';

const useStyles = makeStyles((theme) => ({
    root: {
        minHeight: '100vh',
    },
    mid: {
        display: 'flex',
        justifyContent: 'center',
        alignItems: 'center',
    },
    colLeft: {
        minHeight: '100vh',
        color: 'white',
    },
    colRight: {
        minHeight: '100vh',
    },
    contentLeft: {
        maxWidth: 430,
        margin: '0 auto',
        fontSize: 77,
        lineHeight: '77px',
        fontWeight: 'bold',
        textAlign: 'left',
        textShadow: '7px 7px 9px rgba(0, 0, 0, 0.5)'
    },
    form: {
        padding: '20px 60px',
        margin: 0,
        width: 536,
        maxWidth: '100%',
        position: 'initial',
        top: 'auto',
        [theme.breakpoints.down('md')]: {
            padding: '0px 15px',
        },
    },
    googleBtn: {
        width: '100%',
        height: 42,
        backgroundColor: '#4285f4',
        borderRadius: 2,
        boxShadow: '0 3px 4px 0 rgba(0,0,0,.25)',
        display: 'inline-flex',
        cursor: 'pointer',
        position: 'relative',
        '& .google-icon-wrapper': {
            position: 'absolute',
            marginTop: 1,
            marginLeft: 1,
            width: 40,
            height: 40,
            borderRadius: 2,
            backgroundColor: '#fff',
        },
        '& .google-icon': {
            position: 'absolute',
            marginTop: 11,
            marginLeft: 11,
            width: 18,
            height: 18
        },
        '& .btn-text': {
            color: '#fff',
            fontSize: 14,
            letterSpacing: '0.2px',
            fontFamily: "Roboto",
            display: 'flex',
            alignItems: 'center',
            justifyContent: 'center',
            padding: '0 20px',
            width: '100%',
        },
        '&:hover': {
            boxShadow: '0 0 6px #4285f4'
        },
        '&:active': {
            background: '#1669F2'
        }
    },
    orSeperator: {
        marginTop: 20,
        textAlign: 'center',
        borderTop: '1px solid #ccc',
        '& i': {
            fontSize: 12,
            padding: '0 10px',
            background: '#fff',
            position: 'relative',
            top: '-11px',
            zIndex: 1
        }
    },
    viewMode: {
        position: 'fixed',
        top: 8,
        right: 8,
    }
}));

function Login() {

    const classes = useStyles();

    const { enqueueSnackbar } = useSnackbar();

    const theme = useSelector(state => state.theme);

    const dispatch = useDispatch();
    const { ajax, Loading } = useAjax();

    const valueInital = {
        username: '',
        password: '',
        verification_code: ''
    };

    const [settings, setSettings] = React.useState(false);

    const [showVerificationCode, setShowVerificationCode] = React.useState(false);

    const [formData] = React.useState(valueInital)

    React.useEffect(() => {
        ajax({
            url: 'login/settings',
            method: 'POST',
            success: result => {
                if (result.security && result.template) {
                    setSettings(result);
                }
            }
        });
    }, []);

    React.useEffect(() => {
        if (settings) {
            if (settings.security_active_recapcha_google * 1 === 1) {
                if (!document.getElementById('recaptcha')) {
                    let script = document.createElement("script");
                    script.id = 'recaptcha';
                    script.src = "https://www.google.com/recaptcha/api.js";
                    script.async = true;

                    script.onload = () => {
                        setTimeout(() => {
                            onLoadRecapCha();
                        }, 500);
                    };
                    document.body.appendChild(script);
                } else {
                    onLoadRecapCha();
                }

            }


            if (settings.security.security_active_signin_with_google_account) {

                if (!document.getElementById('apis_google_com_platform')) {
                    try {

                        let script = document.createElement('script');
                        script.id = 'apis_google_com_platform';
                        script.src = 'https://apis.google.com/js/platform.js';
                        script.async = true;
                        script.onload = () => {
                            setTimeout(() => {
                                onLoadLoginWithGoogleAccount();
                            }, 500);
                        };

                        document.head.appendChild(script);

                    } catch (error) {
                        console.log(error);
                    }

                } else {
                    setTimeout(() => {
                        onLoadLoginWithGoogleAccount();
                    }, 500);
                }
            }
        }
    }, [settings]);

    const onLoadRecapCha = () => {
        window.capcha_login = window.grecaptcha?.render('recaptcha-login', {
            'sitekey': settings.security.security_recaptcha_sitekey
        });
    }

    const onLoadLoginWithGoogleAccount = () => {
        window.gapi.load('auth2', function () {
            let auth2 = window.gapi.auth2.init({
                client_id: settings.security.security_google_oauth_client_id,
                cookiepolicy: 'single_host_origin',
                scope: 'email'
            });

            let element = document.getElementById('googleSignIn');

            auth2.attachClickHandler(element, {},
                function (googleUser) {
                    console.log(googleUser);
                    handleEmailResponse(
                        { loginByEmail: googleUser.getAuthResponse().access_token }
                    );
                    // console.log(googleUser.getAuthResponse().access_token);
                    // console.log('Signed in: ' + googleUser.getBasicProfile().getEmail());
                }, function (error) {
                    console.log(error);
                    // enqueueSnackbar({ content: 'Sign-in error:' + error.error, options: { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'right' } } }, { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'right' } });
                }
            );
        });
    }

    const handleEmailResponse = (data) => {

        ajax({
            url: 'login/check',
            method: 'POST',
            data: data,
            success: result => {
                if (result.requiredVerificationCode) {
                    setShowVerificationCode(true);
                } else if (result.user) {
                    localStorage.setItem('access_token', result.user.access_token);
                    dispatch(updateSidebar(result.sidebar));
                    dispatch(updatePlugins(result.plugins));
                    dispatch(login(result.user));
                }

                if (window.grecaptcha) {
                    window.grecaptcha.reset(window.capcha_login);
                }
            }
        });

    }

    const onClickLogin = () => {

        let data = {
            ...formData,
            showVerificationCode: showVerificationCode
        };

        if (settings.security.security_active_recapcha_google * 1 === 1) {

            let recaptcha = window.grecaptcha.getResponse(window.capcha_login);

            if (!recaptcha) {
                enqueueSnackbar({ content: 'The g-recaptcha-response field is required.', options: { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'left' } } }, { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'left' } });
                return;
            }

            data['g-recaptcha-response'] = recaptcha;
        }

        handleEmailResponse(data);
    };

    const handleUpdateViewMode = (mode) => () => {
        dispatch(changeMode(mode));
    }

    if (!settings) {
        return null;
    }

    return (
        <Grid container className={classes.root} spacing={0}>

            <Hidden smDown>
                <Grid item md={8} className={classes.mid + ' ' + classes.colLeft} style={{ background: (settings.template && settings.template['admin_template_color-left']) ? settings.template['admin_template_color-left'] : '#582979' }}>
                    <p className={classes.contentLeft} dangerouslySetInnerHTML={{
                        __html: settings.template?.admin_template_logan ? settings.template?.admin_template_logan : 'do <br /> something<br /><span style="color:#18b797;font-size: 85px;">you love</span><br /> today</>'
                    }} >
                    </p>
                </Grid>
            </Hidden>
            <Grid item xs={12} md={4} className={classes.mid + ' ' + classes.colRight}>
                <div className={classes.form}>
                    <Typography component="h1" style={{ fontWeight: 'bold', fontSize: 24 }} gutterBottom dangerouslySetInnerHTML={{ __html: settings.template && settings.template['admin_template_headline-right'] ? settings.template['admin_template_headline-right'] : 'Log in' }} />
                    {
                        !showVerificationCode &&
                        <div style={{ marginTop: 24 }}>
                            <div style={{ marginTop: 24 }}>
                                <FieldForm
                                    compoment={'text'}
                                    config={{
                                        title: 'Email or phone number'
                                    }}
                                    required
                                    post={formData}
                                    name={'username'}
                                    onReview={value => { formData.username = value; }}
                                />
                            </div>
                            <div style={{ marginTop: 24 }}>
                                <FieldForm
                                    compoment={'password'}
                                    config={{
                                        title: 'Enter your password',
                                        generator: false
                                    }}
                                    post={formData}
                                    name={'password'}
                                    onReview={value => { formData.password = value; }}
                                />
                            </div>
                        </div>
                    }
                    {
                        showVerificationCode &&
                        <div style={{ marginTop: 42 }}>
                            <Typography variant="h4">2-Step Verification</Typography>

                            <Grid container spacing={2} style={{ margin: '10px 0 30px 0' }}>
                                <Grid item xs={12} md={2}>
                                    <MobileFriendlyIcon style={{ fontSize: 65, color: 'rgb(154 154 154)' }} />
                                </Grid>
                                <Grid item xs={12} md={7}>
                                    <Typography style={{ fontWeight: 500 }} variant="body1">Enter the verification code generated by your mobile application.</Typography>
                                </Grid>
                            </Grid>

                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: 'Verification Code',
                                    generator: false
                                }}
                                post={formData}
                                name={'verification_code'}
                                onReview={value => { formData.verification_code = value; }}
                            />
                        </div>
                    }
                    {
                        settings.security_active_recapcha_google * 1 === 1 &&
                        <div style={{ marginTop: 24 }}>
                            <div className="recaptcha-login" id="recaptcha-login"></div>
                        </div>
                    }
                    <div style={{ marginTop: 32, display: 'flex', justifyContent: 'flex-end' }}>
                        <Button style={{ width: '100%' }} variant="contained" color="primary" disableElevation onClick={onClickLogin}>
                            Sign in
                        </Button>
                        {Loading}
                    </div>
                    {
                        Boolean(settings.security.security_active_signin_with_google_account) &&
                        <div>
                            <div className={classes.orSeperator}>
                                <i>OR</i>
                            </div>
                            <div >
                                <div id="googleSignIn" className={classes.googleBtn}>
                                    <div className="google-icon-wrapper">
                                        <img className="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" />
                                    </div>
                                    <p className="btn-text"><b>Sign in with google</b></p>
                                </div>
                            </div>
                        </div>
                    }
                </div>
                <IconButton className={classes.viewMode} onClick={handleUpdateViewMode(theme.type === 'light' ? 'dark' : 'light')}>
                    <MaterialIcon icon={theme.type === 'light' ? { custom: '<path d="M12 9c1.65 0 3 1.35 3 3s-1.35 3-3 3-3-1.35-3-3 1.35-3 3-3m0-2c-2.76 0-5 2.24-5 5s2.24 5 5 5 5-2.24 5-5-2.24-5-5-5zM2 13h2c.55 0 1-.45 1-1s-.45-1-1-1H2c-.55 0-1 .45-1 1s.45 1 1 1zm18 0h2c.55 0 1-.45 1-1s-.45-1-1-1h-2c-.55 0-1 .45-1 1s.45 1 1 1zM11 2v2c0 .55.45 1 1 1s1-.45 1-1V2c0-.55-.45-1-1-1s-1 .45-1 1zm0 18v2c0 .55.45 1 1 1s1-.45 1-1v-2c0-.55-.45-1-1-1s-1 .45-1 1zM5.99 4.58c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0s.39-1.03 0-1.41L5.99 4.58zm12.37 12.37c-.39-.39-1.03-.39-1.41 0-.39.39-.39 1.03 0 1.41l1.06 1.06c.39.39 1.03.39 1.41 0 .39-.39.39-1.03 0-1.41l-1.06-1.06zm1.06-10.96c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06zM7.05 18.36c.39-.39.39-1.03 0-1.41-.39-.39-1.03-.39-1.41 0l-1.06 1.06c-.39.39-.39 1.03 0 1.41s1.03.39 1.41 0l1.06-1.06z"></path>' } : 'Brightness2Outlined'} />
                </IconButton>
            </Grid>
        </Grid>
    )
}

export default Login
