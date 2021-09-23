import { Button, Chip, FormControl, Input, InputLabel, makeStyles, MenuItem, Select, Typography } from '@material-ui/core';
import Paper from '@material-ui/core/Paper';
import Step from '@material-ui/core/Step';
import StepContent from '@material-ui/core/StepContent';
import StepLabel from '@material-ui/core/StepLabel';
import Stepper from '@material-ui/core/Stepper';
import { FieldForm, LoadingButton, RedirectWithMessage } from 'components';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { checkPermission } from 'utils/user';

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
    selectMulti: {
        '& .MuiSelect-selectMenu': {
            whiteSpace: 'unset',
        }
    }
}));


const ITEM_HEIGHT = 48;
const ITEM_PADDING_TOP = 8;

const MenuProps = {
    PaperProps: {
        style: {
            maxHeight: ITEM_HEIGHT * 4.5 + ITEM_PADDING_TOP,
            width: 250,
        },
    },
};


function VerifyWebsite({ meta, ajaxPluginHandle, loading }) {

    const classes = useStyles();

    const [activeStep, setActiveStep] = React.useState(meta.complete_installation ? 3 : 0);
    const [websites, setWebsites] = React.useState(meta.searchConsoleWebsites ?? []);
    let view = '';


    const [config, setConfig] = React.useState({
        authUrl: '',
        access_code: '',
        account: {},
        view: view,
    });

    const handleChangeMultiple = (event) => {
        setWebsites(event.target.value);
    };

    const handleClickAuthUrl = (e) => {
        e.preventDefault();
        window.open(config.authUrl, 'Google Auth', 'toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=no, resizable=no, copyhistory=no, width=640, height=580, top=' + (window.screen.height / 2 - 290) + ', left=' + (window.screen.width / 2 - 320));
    };


    const handleNext = () => {

        if (activeStep === 0) {
            if (!loading.open) {
                ajaxPluginHandle({
                    url: 'search-console/settingAccount',
                    data: {
                        action: 'settingAccount',
                        file_config_account: meta.file_config_account
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
                    url: 'search-console/settingAuthorizationToken',
                    data: {
                        action: 'settingAuthorizationToken',
                        access_code: config.access_code
                    },
                    success: (result) => {
                        if (result.plugin) {
                            setActiveStep((prevActiveStep) => prevActiveStep + 1);
                            setWebsites([]);
                        }
                    }
                });
            }
        } else {
            if (!loading.open) {
                ajaxPluginHandle({
                    url: 'search-console/settingWebproperties',
                    data: {
                        action: 'settingWebproperties',
                        searchConsoleWebsites: websites
                    },
                    success: (result) => {
                        if (result.success) {
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
    };

    const valueInitial = {
        htmlFIle: meta['webmaster-tools']?.google?.file,
        metaTag: meta['webmaster-tools']?.google?.tag,
    };

    const [value] = React.useState({
        old: JSON.parse(JSON.stringify(valueInitial)),
        new: JSON.parse(JSON.stringify(valueInitial)),
    });

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
                    post={meta}
                    name={'file_config_account'}
                    onReview={(v, key) => { meta.file_config_account = v; }}
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
            label: 'Select Website',
            content: <>
                <Typography>
                    The Webproperties collection is a set of Webproperty resources, each of which describes a web property available to an authenticated user.
                </Typography>
                <br />
                <FormControl className={classes.selectMulti} variant="outlined" fullWidth>
                    <InputLabel id="demo-mutiple-chip-label">Website</InputLabel>
                    <Select
                        label="Website"
                        multiple
                        variant="outlined"
                        value={websites}
                        onChange={handleChangeMultiple}
                        input={<Input id="select-multiple-chip" />}
                        renderValue={(selected) => (
                            <div className={classes.chips}>
                                {selected.map((value) => (
                                    <Chip style={{ background: '#e0e0e0', margin: '4px 4px 0 0' }} key={value} label={value} className={classes.chip} />
                                ))}
                            </div>
                        )}
                        MenuProps={MenuProps}
                    >
                        {
                            meta.sites &&
                            meta.sites.map((item, i) => (
                                <MenuItem key={i} value={item}>
                                    {item.search('sc-domain:') > -1 ? <><strong>Domain property: </strong>&nbsp;{item.replace('sc-domain:', '')}</> : item}
                                </MenuItem>
                            ))}
                    </Select>
                </FormControl>
            </>
        }
    ];

    if (!checkPermission('plugin_vn4seo_setting')) {
        return <RedirectWithMessage />
    }

    return (
        <SettingEdit1
            title="Search Console"
            backLink="/plugin/vn4seo/settings"
            description="Manage Search Console properties, test URLs, and view your Google Search data and errors."
        >

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
        </SettingEdit1>
    );
}

export default VerifyWebsite
