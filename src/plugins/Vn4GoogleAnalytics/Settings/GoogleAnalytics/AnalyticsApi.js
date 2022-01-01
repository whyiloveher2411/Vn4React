import { Button } from '@material-ui/core';
import Paper from '@material-ui/core/Paper';
import Step from '@material-ui/core/Step';
import StepContent from '@material-ui/core/StepContent';
import StepLabel from '@material-ui/core/StepLabel';
import Stepper from '@material-ui/core/Stepper';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import { FieldForm, LoadingButton, RedirectWithMessage } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';
import SelectView from './../../compoments/SettingAnalytics/SelectView';

const useStyles = makeStyles((theme) => ({
    button: {
        marginTop: theme.spacing(1),
        marginRight: theme.spacing(1),
    },
    actionsContainer: {
        marginBottom: theme.spacing(2),
    },
    resetContainer: {
        padding: theme.spacing(3),
    },
}));

function AnalyticsApi({ post, name, onReview }) {

    const classes = useStyles();

    const [activeStep, setActiveStep] = React.useState(3);

    let view = '';

    const [config, setConfig] = React.useState({
        authUrl: '',
        access_code: '',
        account: {},
        view: view,
    });

    const useAjax1 = useAjax();

    const handleClickAuthUrl = (e) => {
        e.preventDefault();
        window.open(config.authUrl, 'Google Auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=640, height=580, top=' + (window.screen.height / 2 - 290) + ', left=' + (window.screen.width / 2 - 320));
    };

    React.useEffect(() => {
        if (typeof post[name] !== 'object') {

            let value = {};
            try {
                value = JSON.parse(post[name]) ?? {};
            } catch (error) {
                value = {};
            }

            post[name] = value;

            onReview(value, name);
        }

        if (post[name].complete_installation) {
            setActiveStep(3);
        } else {
            setActiveStep(0);
        }

    }, []);

    const steps = [
        {
            label: 'Get file conffig app',
            content: <>
                <Typography>
                    Before users can view their account information on the Google Analytics web site,
                    they must first log in to their Google Accounts. Similarly, when users first access your application,
                    they need to authorize your application to access their data.
                </Typography>
                <br />
                <FieldForm
                    compoment='asset-file'
                    config={{
                        title: 'Config Account'
                    }}
                    post={post[name] ?? {}}
                    name={'file_config_account'}
                    onReview={(v, key) => {
                        onReview({
                            ...post[name],
                            file_config_account: v,
                            access_code: '',
                        }, name);
                    }}
                />
            </>
        },
        {
            label: 'Get access token',
            content: <>
                <Typography>
                    Every request your application sends to the Analytics API must include an authorization token.
                    The token also identifies your application to Google.
                </Typography>
                <Button style={{ margin: '8px 0' }} onClick={handleClickAuthUrl} color="primary">Get Access Code.</Button>
                <FieldForm
                    compoment='text'
                    config={{
                        title: 'Authorization token'
                    }}
                    post={post}
                    name={'access_code'}
                    onReview={(v, key) => {
                        setConfig({ ...config, access_code: v })
                    }}
                />
            </>
        },
        {
            label: 'Select View',
            content: <>
                <Typography>
                    The Webproperties collection is a set of Webproperty resources, each of which describes a web property available to an authenticated user.
                </Typography>
                <br />
                <SelectView post={config} name={'view'} onReview={v => { config.view = v; }} />
            </>
        }
    ];

    const handleNext = () => {

        if (activeStep === 0) {
            if (!useAjax1.open) {
                useAjax1.ajax({
                    url: 'plugin/vn4-google-analytics/settings/settingAccount',
                    data: {
                        step: 'settingAccount',
                        file_config_account: post[name].file_config_account
                    },
                    success: (result) => {
                        if (result.value) {
                            onReview({
                                ...post[name],
                                ...result.value
                            }, name);
                            setConfig(prev => ({ ...prev, authUrl: result.authUrl }));
                            setActiveStep((prevActiveStep) => prevActiveStep + 1);
                        }
                    }
                });
            }
        } else if (activeStep === 1) {
            if (!useAjax1.open) {
                useAjax1.ajax({
                    url: 'plugin/vn4-google-analytics/settings/settingAuthorizationToken',
                    data: {
                        step: 'settingAuthorizationToken',
                        access_code: config.access_code
                    },
                    success: (result) => {
                        if (result.account) {
                            setConfig({ ...config, account: result.account });
                            setActiveStep((prevActiveStep) => prevActiveStep + 1);
                            onReview({
                                ...post[name],
                                access_code: config.access_code,
                                ...result.value
                            }, name);
                        }
                    }
                });
            }
        } else {
            if (!useAjax1.open) {
                useAjax1.ajax({
                    url: 'plugin/vn4-google-analytics/settings/settingWebproperties',
                    data: {
                        step: 'settingWebproperties',
                        view: config.view
                    },
                    success: (result) => {

                        if (result.value) {
                            onReview({
                                ...post[name],
                                ...result.value
                            }, name);
                            setConfig(prev => ({ ...prev, authUrl: result.authUrl }));
                            setActiveStep((prevActiveStep) => prevActiveStep + 1);
                        }

                    }
                });
            }
        }
    };

    const handleBack = () => {
        setActiveStep((prevActiveStep) => prevActiveStep - 1);
    };

    const handleReset = () => {
        setActiveStep(0);
        onReview({
            ...post[name],
            complete_installation: false,
        });
    };

    if (!usePermission('plugin_google_analytics_setting').plugin_google_analytics_setting) {
        return <RedirectWithMessage />
    }

    if (typeof post[name] !== 'object') {
        return <></>;
    }

    return (
        <div style={parseInt(post['google_analytics/analytics_api/active']) === 1 ? {} : { opacity: '.2', pointerEvents: 'none', cursor: 'not-allowed' }}>
            <Stepper activeStep={activeStep} orientation="vertical">
                {steps.map((step, index) => (
                    <Step key={index}>
                        <StepLabel>{step.label}</StepLabel>
                        <StepContent>
                            {step.content}
                            <div className={classes.actionsContainer}>
                                <div>
                                    <Button
                                        disabled={activeStep === 0}
                                        onClick={handleBack}
                                        className={classes.button}
                                    >Back</Button>
                                    <LoadingButton
                                        variant="contained"
                                        color="primary"
                                        onClick={handleNext}
                                        className={classes.button}
                                        open={useAjax1.open}
                                    >
                                        {activeStep === steps.length - 1 ? 'Finish' : 'Next'}
                                    </LoadingButton>
                                </div>
                            </div>
                        </StepContent>
                    </Step>
                ))}
            </Stepper>
            {activeStep === steps.length && (
                <Paper square elevation={0} className={classes.resetContainer}>
                    <Typography>All steps completed - you&apos;re finished</Typography>
                    <Button onClick={handleReset} className={classes.button}>Reset</Button>
                </Paper>
            )}
        </div>
    )
}

export default AnalyticsApi
