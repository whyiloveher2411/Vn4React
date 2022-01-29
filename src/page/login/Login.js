import { Button, Grid, Hidden, IconButton, Typography } from '@material-ui/core';
import Checkbox from '@material-ui/core/Checkbox';
import FormControlLabel from '@material-ui/core/FormControlLabel';
import FormGroup from '@material-ui/core/FormGroup';
import { makeStyles } from '@material-ui/core/styles';
import MobileFriendlyIcon from '@material-ui/icons/MobileFriendly';
import { MaterialIcon } from 'components';
import FieldForm from 'components/FieldForm';
import { useSnackbar } from 'notistack';
import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { updateAccessToken } from 'reducers/user';
import { changeMode } from 'reducers/viewMode';
import setting from 'services/setting';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { themes } from 'utils/viewMode';

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
        username: 'dangthuyenquan@gmail.com',
        password: 'dangthuyenquan',
        _password: 'dangthuyenquan',
        verification_code: ''
    };

    const [settings, setSettings] = React.useState(false);

    const [showVerificationCode, setShowVerificationCode] = React.useState(false);

    const [formData, setFormData] = React.useState(valueInital)

    React.useEffect(() => {

        (async () => {

            let config = await setting.getLoginConfig();

            setSettings(config);

        })();

    }, []);

    React.useEffect(() => {
        if (settings) {

            if (settings?.security.security_active_recaptcha_google * 1 === 1) {
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


            if (settings?.security.security_active_signin_with_google_account) {

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
            'sitekey': settings?.security.security_recaptcha_sitekey
        });
    }

    const onLoadLoginWithGoogleAccount = () => {
        window.gapi.load('auth2', function () {
            let auth2 = window.gapi.auth2.init({
                client_id: settings?.security.security_google_oauth_client_id,
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
                } else if (result.access_token) {
                    dispatch(updateAccessToken(result.access_token));
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

        if (settings?.security.security_active_recaptcha_google * 1 === 1 && window.grecaptcha) {

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
                <Grid item md={8} className={classes.mid + ' ' + classes.colLeft} style={{ background: (settings.template && settings.template.admin_template_color_left) ? settings.template.admin_template_color_left : '#582979' }}>
                    <p className={classes.contentLeft} dangerouslySetInnerHTML={{
                        __html: settings.template?.admin_template_slogan ? settings.template?.admin_template_slogan : 'do <br /> something<br /><span style="color:#18b797;font-size: 85px;">you love</span><br /> today</>'
                    }} >
                    </p>
                </Grid>
            </Hidden>
            <Grid item xs={12} md={4} className={classes.mid + ' ' + classes.colRight}>
                <div className={classes.form}>
                    <Typography component="h1" style={{ fontWeight: 'bold', fontSize: 24 }} gutterBottom dangerouslySetInnerHTML={{ __html: settings.template && settings.template['admin_template_headline-right'] ? settings.template['admin_template_headline-right'] : __('Sign in') }} />
                    {
                        !showVerificationCode &&
                        <div style={{ marginTop: 24 }}>
                            <div style={{ marginTop: 24 }}>
                                <FieldForm
                                    compoment={'text'}
                                    config={{
                                        title: __('Email or phone number')
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
                                        title: __('Enter your password'),
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
                            <Typography variant="h4">{__('2-Step Verification')}</Typography>

                            <Grid container spacing={2} style={{ margin: '10px 0 30px 0' }}>
                                <Grid item xs={12} md={2}>
                                    <MobileFriendlyIcon style={{ fontSize: 65, color: 'rgb(154 154 154)' }} />
                                </Grid>
                                <Grid item xs={12} md={7}>
                                    <Typography style={{ fontWeight: 500 }} variant="body1">{__('Enter the verification code generated by your mobile application.')}</Typography>
                                </Grid>
                            </Grid>

                            <FieldForm
                                compoment={'text'}
                                config={{
                                    title: __('Verification Code'),
                                    generator: false
                                }}
                                post={formData}
                                name={'verification_code'}
                                onReview={value => { formData.verification_code = value; }}
                            />
                        </div>
                    }
                    {
                        settings?.security.security_active_recaptcha_google * 1 === 1 &&
                        <div style={{ marginTop: 24 }}>
                            <div className="recaptcha-login" id="recaptcha-login"></div>
                        </div>
                    }

                    {
                        settings?.security.security_enable_remember_me &&
                        <div style={{ marginTop: 24 }}>
                            <FormGroup>
                                <FormControlLabel
                                    style={{ marginRight: 24 }}
                                    control={<Checkbox
                                        onClick={() => {
                                            if (formData.remember_me) {
                                                setFormData({ ...formData, remember_me: 0 });
                                            } else {
                                                setFormData({ ...formData, remember_me: 1 });
                                            }
                                        }} checked={Boolean(formData.remember_me)} color="primary" />}
                                    label={__('Remember Me')}
                                />
                            </FormGroup>
                            {/* <FieldForm
                            compoment={'checkbox'}
                            config={{
                                title: __('Remember Me'),

                            }}
                            post={formData}
                            name={'remember_me'}
                            onReview={value => { formData.remember_me = value; }}
                        /> */}
                        </div>
                    }

                    <div style={{ marginTop: 32, display: 'flex', justifyContent: 'flex-end' }}>
                        <Button style={{ width: '100%' }} variant="contained" color="primary" disableElevation onClick={onClickLogin}>
                            {__('Sign in')}
                        </Button>
                        {Loading}
                    </div>
                    {
                        Boolean(settings?.security.security_active_signin_with_google_account) &&
                        <div>
                            <div className={classes.orSeperator}>
                                <i>{__('OR')}</i>
                            </div>
                            <div >
                                <div id="googleSignIn" className={classes.googleBtn}>
                                    <div className="google-icon-wrapper">
                                        <img className="google-icon" src="https://upload.wikimedia.org/wikipedia/commons/5/53/Google_%22G%22_Logo.svg" />
                                    </div>
                                    <p className="btn-text"><b>{__('Sign in with google')}</b></p>
                                </div>
                            </div>
                        </div>
                    }
                </div>
                <IconButton className={classes.viewMode} onClick={handleUpdateViewMode(theme.type === 'light' ? 'dark' : 'light')}>
                    <MaterialIcon icon={themes[theme.type]?.icon} />
                </IconButton>
            </Grid>
        </Grid>
    )
}

export default Login
