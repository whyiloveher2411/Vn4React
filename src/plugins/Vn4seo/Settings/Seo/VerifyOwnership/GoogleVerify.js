import { Accordion, AccordionDetails, makeStyles, Typography } from '@material-ui/core';
import AccordionSummary from '@material-ui/core/AccordionSummary';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import { FieldForm } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { __p } from 'utils/i18n';
import { usePermission } from 'utils/user';

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

function GoogleVerify({ post, onReview }) {

    const classes = useStyles();

    const [expanded, setExpanded] = React.useState(false);

    const handleChange = (panel) => (event, isExpanded) => {
        setExpanded(isExpanded ? panel : false);
    };

    if (!usePermission('plugin_vn4seo_setting').plugin_vn4seo_setting) {
        return <RedirectWithMessage />
    }

    return (
        <>
            <Accordion expanded={expanded === 'panel1'} onChange={handleChange('panel1')}>
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon />}
                    aria-controls="panel1bh-content"
                    id="panel1bh-header"
                >
                    <Typography className={classes.heading}>{__p('HTML file', 'vn4seo')}</Typography>
                    <Typography className={classes.secondaryHeading}>{__p('Upload the HTML file to your website', 'vn4seo')}</Typography>
                </AccordionSummary>
                <AccordionDetails>
                    <FieldForm
                        compoment='asset-file'
                        config={{
                            title: __p('Verification file html', 'vn4seo')
                        }}
                        post={post}
                        name={'seo/verify_ownership/htmlfile'}
                        onReview={(v) => { onReview(v, 'seo/verify_ownership/htmlfile') }}
                    />
                </AccordionDetails>
            </Accordion>
            <Accordion expanded={expanded === 'panel2'} onChange={handleChange('panel2')}>
                <AccordionSummary
                    expandIcon={<ExpandMoreIcon />}
                    aria-controls="panel2bh-content"
                    id="panel2bh-header"
                >
                    <Typography className={classes.heading}>{__p('HTML tag', 'vn4seo')}</Typography>
                    <Typography className={classes.secondaryHeading}>{__p('Add the meta tag to your website\'s homepage', 'vn4seo')}</Typography>
                </AccordionSummary>
                <AccordionDetails>
                    <FieldForm
                        compoment='text'
                        config={{
                            title: __p('Meta Tag', 'vn4seo')
                        }}
                        post={post}
                        name={'seo/verify_ownership/metatag'}
                        onReview={(v) => { onReview(v, 'seo/verify_ownership/metatag') }}
                    />
                </AccordionDetails>
            </Accordion>
        </>
    );
}

export default GoogleVerify
