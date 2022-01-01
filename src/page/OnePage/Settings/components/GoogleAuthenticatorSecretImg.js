import { Box } from '@material-ui/core';
import Card from '@material-ui/core/Card';
import CardContent from '@material-ui/core/CardContent';
import Collapse from '@material-ui/core/Collapse';
import Grid from '@material-ui/core/Grid';
import IconButton from '@material-ui/core/IconButton';
import InputAdornment from '@material-ui/core/InputAdornment';
import RefreshIcon from '@material-ui/icons/Refresh';
import { Skeleton } from '@material-ui/lab';
import FieldForm from 'components/FieldForm';
import React from 'react';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';


function GoogleAuthenticatorSecretImg({ post, onReview, name, config }) {

    const [securityGoogleAuthenticatorSecret, setSecurityGoogleAuthenticatorSecret] = React.useState(post.security_google_authenticator_secret);
    const [securityGoogleAuthenticatorSecretImg, setSecurityGoogleAuthenticatorSecretImg] = React.useState({
        src: '',
        isLoaded: false
    });

    const { ajax } = useAjax();

    const randomGoogleAuthenticatorSecret = () => {
        ajax({
            url: 'settings/random-google-authenticator-secret',
            method: 'POST',
            data: {
                action: 'RANDOM_SECRET',
            },
            success: (result) => {
                if (result.secret) {
                    setSecurityGoogleAuthenticatorSecret(result.secret);
                    setSecurityGoogleAuthenticatorSecretImg({ src: result.qrCodeUrl, isLoaded: false });
                    onReview(result.secret, 'security_google_authenticator_secret');
                }
            }
        });
    }

    React.useEffect(() => {

        if (securityGoogleAuthenticatorSecret) {
            ajax({
                url: 'settings/random-google-authenticator-secret',
                method: 'POST',
                data: {
                    action: 'GET_IMAGE',
                    secret: securityGoogleAuthenticatorSecret,
                },
                success: (result) => {
                    if (result.secret) {
                        setSecurityGoogleAuthenticatorSecret(result.secret);
                        setSecurityGoogleAuthenticatorSecretImg({ src: result.qrCodeUrl, isLoaded: false });
                        onReview(result.secret, 'security_google_authenticator_secret');
                    }
                }
            });
        }

    }, [])

    return (
        <>
            <FieldForm
                compoment={'text'}
                config={config}
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
                    <Box display="flex">
                        <img
                            onLoad={() => {
                                setSecurityGoogleAuthenticatorSecretImg(prev => ({ ...prev, isLoaded: true }));
                            }}
                            alt="QR Code"
                            style={{
                                marginTop: 8,
                                opacity: securityGoogleAuthenticatorSecretImg.isLoaded ? 1 : 0,
                                position: securityGoogleAuthenticatorSecretImg.isLoaded ? 'initial' : 'absolute',
                            }}
                            src={securityGoogleAuthenticatorSecretImg.src}
                        />
                        {
                            securityGoogleAuthenticatorSecretImg.isLoaded === false &&
                            <Skeleton style={{ width: 200, height: 200, marginTop: 8, transform: 'scale(1, 1)' }} />
                        }
                    </Box>
                    :
                    <div>
                        <Skeleton style={{ width: 200, height: 200, marginTop: 8, transform: 'scale(1, 1)' }} />
                    </div>
            }
        </>
    )
}


export default GoogleAuthenticatorSecretImg
