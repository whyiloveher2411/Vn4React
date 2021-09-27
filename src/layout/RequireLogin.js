import { Grid, makeStyles, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import MobileFriendlyIcon from '@material-ui/icons/MobileFriendly';
import { Alert } from '@material-ui/lab';
import { updateRequireLogin } from 'actions/requiredLogin';
import { login, logout } from 'actions/user';
import { useSnackbar } from 'notistack';
import React from 'react';
import { useDispatch, useSelector } from 'react-redux';
import { useAjax } from 'utils/useAjax';
import FieldForm from 'components/FieldForm';


const useStyles = makeStyles((theme) => ({
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
    }
}));


function RequireLogin() {

    const settings = useSelector(state => state.settings);
    const requireLogin = useSelector(state => state.requireLogin);
    const user = useSelector(state => state.user);

    const dispatch = useDispatch();

    const classes = useStyles();
    const { enqueueSnackbar } = useSnackbar();

    const { ajax, Loading } = useAjax();

    const valueInital = {
        username: user.email,
        password: '',
        verification_code: ''
    };

    const [showVerificationCode, setShowVerificationCode] = React.useState(false);

    const [formData, setFormData] = React.useState(valueInital);

    React.useEffect(() => {
        if (requireLogin.open) {
            setFormData({ ...formData, verification_code: '' });
        }
    }, [requireLogin]);

    React.useEffect(() => {

        if (settings && requireLogin.open) {
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
                    setTimeout(() => {
                        onLoadRecapCha();
                    }, 500);
                }

            }

            if (settings.security_active_signin_with_google_account) {

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

    }, [requireLogin]);

    const onClickLogin = () => {

        let data = {
            ...formData,
            showVerificationCode: showVerificationCode
        };

        if (settings.security_active_recapcha_google * 1 === 1) {

            let recaptcha = window.grecaptcha.getResponse(window.capcha_login);

            if (!recaptcha) {
                enqueueSnackbar({ content: 'The g-recaptcha-response field is required.', options: { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'left' } } }, { variant: 'error', anchorOrigin: { vertical: 'bottom', horizontal: 'left' } });
                return;
            }

            data['g-recaptcha-response'] = recaptcha;
        }

        ajax({
            url: 'login/check',
            method: 'POST',
            data: data,
            success: result => {

                if (result.requiredVerificationCode) {
                    setShowVerificationCode(true);
                } else if (result.user) {
                    if (requireLogin.updateUser) {
                        dispatch(login(result.user));
                    }

                    dispatch(updateRequireLogin({ open: false, updateUser: requireLogin.updateUser }));
                    localStorage.setItem('access_token', result.user.access_token);

                    if (window.__afterLogin) {

                        Object.keys(window.__afterLogin).forEach(key => {
                            window.__afterLogin[key].callback(window.__afterLogin[key].params);
                        });

                        window.__afterLogin = null;

                    }

                    if (requireLogin.callback) {
                        requireLogin.callback();
                    }

                }

                if (window.grecaptcha) {
                    window.grecaptcha.reset(window.capcha_login);
                }
            }
        });

    };


    const onLoadRecapCha = () => {
        try {
            if (document.getElementById('recaptcha-login')) {
                window.capcha_login = window.grecaptcha?.render('recaptcha-login', {
                    'sitekey': settings.security_recaptcha_sitekey
                });
            }
        } catch (error) {

        }

    }

    const onLoadLoginWithGoogleAccount = () => {
        if (window.gapi) {
            window.gapi.load('auth2', function () {
                let auth2 = window.gapi.auth2.init({
                    client_id: settings.security_google_oauth_client_id,
                    cookiepolicy: 'single_host_origin',
                    scope: 'email'
                });

                let element = document.getElementById('googleSignIn');

                auth2.attachClickHandler(element, {},
                    function (googleUser) {
                        console.log(googleUser);
                        handleEmailResponse(googleUser.getAuthResponse().access_token);
                    }, function (error) {
                        console.log(error);
                    }
                );
            });
        }
    }

    const handleLogout = () => {
        dispatch(updateRequireLogin({ open: false, updateUser: requireLogin.updateUser }));
        dispatch(logout());
    }

    const handleEmailResponse = (resp) => {

        ajax({
            url: 'login/check',
            method: 'POST',
            data: {
                loginByEmail: resp,
            },
            success: result => {

                if (result.requiredVerificationCode) {
                    setShowVerificationCode(true);
                } else if (result.user) {

                    if (requireLogin.updateUser) {
                        dispatch(login(result.user));
                    }
                    dispatch(updateRequireLogin({ open: false, updateUser: requireLogin.updateUser }));
                    localStorage.setItem('access_token', result.user.access_token);
                }
            }
        });
    }


    return (
        <Dialog
            open={requireLogin.open}
            onClose={() => { }}
            scroll='paper'
            maxWidth='xs'
            aria-labelledby="scroll-dialog-title"
            aria-describedby="scroll-dialog-description"
            fullWidth
            className={classes.disableOutline}
        >
            <DialogTitle disableTypography={true} style={{ fontSize: 22, background: '#455a64', color: 'white', display: 'flex', justifyContent: 'space-between' }}>Sign in <Button variant="contained" onClick={handleLogout}>Logout</Button></DialogTitle>
            <DialogContent dividers={true}>
                <DialogContentText
                    component="div"
                >
                    <Grid container className={classes.root} spacing={3}>
                        <Grid item xs={12} md={12}>
                            <Alert icon={false} severity="info">
                                Your session has expired. Please log in to continue where you let off.
                            </Alert>
                        </Grid>

                        {
                            showVerificationCode ?
                                <Grid item xs={12} md={12}>
                                    <Typography variant="h4">2-Step Verification</Typography>

                                    <Grid container spacing={2} style={{ margin: '10px 0 30px 0' }}>
                                        <Grid item xs={12} md={2}>
                                            <MobileFriendlyIcon style={{ fontSize: 65, color: 'rgb(154 154 154)' }} />
                                        </Grid>
                                        <Grid item xs={12} md={10}>
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
                                        onReview={value => { setFormData({ ...formData, verification_code: value }) }}
                                    />
                                </Grid>
                                :
                                <>
                                    <Grid item xs={12} md={12}>
                                        <FieldForm
                                            compoment={'text'}
                                            config={{
                                                title: 'Email or phone number'
                                            }}
                                            required
                                            post={formData}
                                            disabled
                                            name={'username'}
                                            onReview={value => { setFormData(prev => ({ ...prev, username: value })) }}
                                        />
                                    </Grid>
                                    <Grid item xs={12} md={12}>
                                        <FieldForm
                                            compoment={'password'}
                                            config={{
                                                title: 'Enter your password',
                                                generator: false
                                            }}
                                            post={formData}
                                            name={'password'}
                                            onReview={value => { setFormData(prev => ({ ...prev, password: value })) }}
                                        />
                                    </Grid>
                                </>
                        }

                        {
                            settings.security_active_recapcha_google * 1 === 1 &&
                            <Grid item xs={12} md={12}>
                                <div className="recaptcha-login" id="recaptcha-login"></div>
                            </Grid>
                        }

                        <Grid item xs={12} md={12}>
                            <Button style={{ width: '100%' }} variant="contained" color="primary" disableElevation onClick={onClickLogin}>
                                Sign in
                            </Button>
                        </Grid>

                        {
                            Boolean(settings.security_active_signin_with_google_account) &&
                            <Grid item xs={12} md={12}>
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
                            </Grid>
                        }



                    </Grid>
                </DialogContentText>
            </DialogContent>

            {Loading}
        </Dialog>
    )
}

export default RequireLogin
