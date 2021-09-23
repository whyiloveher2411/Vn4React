import { Accordion, AccordionDetails, Box, makeStyles, Typography } from '@material-ui/core';
import AccordionSummary from '@material-ui/core/AccordionSummary';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import { FieldForm, LoadingButton } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { checkPermission } from 'utils/user';

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
    },
    heading: {
        fontSize: theme.typography.pxToRem(15),
        flexBasis: '33.33%',
        flexShrink: 0,
    },
    secondaryHeading: {
        padding: '0 8px',
        fontSize: theme.typography.pxToRem(15),
        color: theme.palette.text.secondary,
    },
}));

function VerifyWebsite({ meta, ajaxPluginHandle, loading }) {

    console.log(meta);
    const classes = useStyles();

    const [expanded, setExpanded] = React.useState(false);

    const handleChange = (panel) => (event, isExpanded) => {
        setExpanded(isExpanded ? panel : false);
    };

    const valueInitial = {
        htmlFIle: meta['webmaster-tools']?.google?.file,
        metaTag: meta['webmaster-tools']?.google?.tag,
    };

    const [value] = React.useState({
        old: JSON.parse(JSON.stringify(valueInitial)),
        new: JSON.parse(JSON.stringify(valueInitial)),
    });

    const handleSubmitVerify = () => {
        if (!loading.open) {
            ajaxPluginHandle({
                url: 'settings/verify-website',
                data: {
                    ...value.new,
                    action: 'verify-website'
                },
            });
        }
    }

    if (!checkPermission('plugin_vn4seo_setting')) {
        return <RedirectWithMessage />
    }

    return (
        <SettingEdit1
            title="Verify your site ownership"
            backLink="/plugin/vn4seo/settings"
            description="Verification is the process of proving that you own the property that you claim to own. We need to confirm ownership because once you are verified for a property, you have access to its Google Search data, and can affect its presence on Google Search. Every Search Console property requires at least one verified owner."
        >
            <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon />}
                    aria-controls="panel1bh-content"
                    id="panel1bh-header"
                >
                    <Typography className={classes.heading}>HTML file</Typography>
                    <Typography className={classes.secondaryHeading}>Upload the HTML file to your website</Typography>
                </AccordionSummary>
                <AccordionDetails>
                    <FieldForm
                        compoment='asset-file'
                        config={{
                            title: 'Verification file html'
                        }}
                        post={value.new}
                        name={'htmlFIle'}
                        onReview={(v) => { value.new.htmlFIle = v; }}
                    />
                </AccordionDetails>
            </Accordion>
            <Accordion expanded={expanded === 'panel2'} onChange={handleChange('panel2')}>
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon />}
                    aria-controls="panel2bh-content"
                    id="panel2bh-header"
                >
                    <Typography className={classes.heading}>HTML tag</Typography>
                    <Typography className={classes.secondaryHeading}>Add the meta tag to your website's homepage</Typography>
                </AccordionSummary>
                <AccordionDetails>
                    <FieldForm
                        compoment='text'
                        config={{
                            title: 'Meta Tag'
                        }}
                        post={value.new}
                        name={'metaTag'}
                        onReview={(v) => { value.new.metaTag = v; }}
                    />
                </AccordionDetails>
            </Accordion>
            <br />
            <Box display="flex" justifyContent="flex-end">
                <LoadingButton
                    className={'btn-green-save'}
                    onClick={handleSubmitVerify}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>

        </SettingEdit1>
    );
}

export default VerifyWebsite
