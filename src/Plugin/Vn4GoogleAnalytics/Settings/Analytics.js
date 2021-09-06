import { Button, Card, CardContent } from '@material-ui/core';
import Paper from '@material-ui/core/Paper';
import Step from '@material-ui/core/Step';
import StepContent from '@material-ui/core/StepContent';
import StepLabel from '@material-ui/core/StepLabel';
import Stepper from '@material-ui/core/Stepper';
import { makeStyles } from '@material-ui/core/styles';
import Typography from '@material-ui/core/Typography';
import { FieldForm, LoadingButton, RedirectWithMessage } from 'components';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { checkPermission } from 'utils/user';
import SelectView from './../compoments/SettingAnalytics/SelectView';


const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
    },
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

function EmbedCode({ meta, ajaxPluginHandle, loading }) {

    const classes = useStyles();

    const [value, setValue] = React.useState(meta);

    const [activeStep, setActiveStep] = React.useState(value.complete_installation ? 3 : 0);

    let view = '';

    if (value.listAnalyticsWebsite) {
        let keys = Object.keys(value.listAnalyticsWebsite);
        if (keys[0]) {
            view = JSON.stringify(value.listAnalyticsWebsite[keys[0]]);
        }

    }

    const [config, setConfig] = React.useState({
        authUrl: '',
        access_code: '',
        account: {},
        view: view,
    });


    const handleClickAuthUrl = (e) => {
        e.preventDefault();
        window.open(config.authUrl, 'Google Auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=640, height=580, top=' + (window.screen.height / 2 - 290) + ', left=' + (window.screen.width / 2 - 320));
    };

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
                    post={value}
                    name={'file_config_account'}
                    onReview={(v, key) => { value.file_config_account = v; }}
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
                    post={value}
                    name={'access_code'}
                    onReview={(v, key) => { value.access_code = v; setConfig({ ...config, access_code: v }) }}
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
            if (!loading.open) {
                ajaxPluginHandle({
                    url: 'settings/settingAccount',
                    data: {
                        step: 'settingAccount',
                        file_config_account: value.file_config_account
                    },
                    success: (result) => {
                        if (result.success) {
                            setConfig(prev => ({ ...prev, authUrl: result.authUrl }));
                            setActiveStep((prevActiveStep) => prevActiveStep + 1);
                        }
                    }
                });
            }
        } else if (activeStep === 1) {
            if (!loading.open) {
                ajaxPluginHandle({
                    url: 'settings/settingAuthorizationToken',
                    data: {
                        step: 'settingAuthorizationToken',
                        access_code: config.access_code
                    },
                    success: (result) => {
                        if (result.account) {
                            setConfig({ ...config, account: result.account });
                            setActiveStep((prevActiveStep) => prevActiveStep + 1);
                        }
                    }
                });
            }
        } else {
            if (!loading.open) {
                ajaxPluginHandle({
                    url: 'settings/settingWebproperties',
                    data: {
                        step: 'settingWebproperties',
                        view: config.view
                    },
                    success: () => {
                        setActiveStep((prevActiveStep) => prevActiveStep + 1);
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
    };

    if (!checkPermission('plugin_google_analytics_setting')) {
        return <RedirectWithMessage />
    }

    return (
        <SettingEdit1
            title="Analytics"
            backLink="/plugin/vn4-google-analytics/settings"
            description="We believe that it’s easy to double your traffic and sales when you know exactly how people find and use your website. Vn4 Google Analtyics shows you the stats that matter, so you can grow your business with confidence."
        >
            <Card>
                <CardContent>
                    <div className={classes.root}>
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
                                                    open={loading.open}
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
                </CardContent>
            </Card>
        </SettingEdit1>
    )
}

export default EmbedCode
