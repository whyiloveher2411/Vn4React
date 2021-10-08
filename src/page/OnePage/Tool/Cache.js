import { Accordion, AccordionSummary, Divider, makeStyles, Typography } from '@material-ui/core';
import AccordionActions from '@material-ui/core/AccordionActions';
import AccordionDetails from '@material-ui/core/AccordionDetails';
import Button from '@material-ui/core/Button';
import Chip from '@material-ui/core/Chip';
import ExpandMoreIcon from '@material-ui/icons/ExpandMore';
import CircularProgress from '@material-ui/core/CircularProgress';
import { Skeleton } from '@material-ui/lab';
import { SettingGroup } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import { __ } from 'utils/i18n';
import { clearCache } from './cacheAction';

const useStyles = makeStyles((theme) => ({

    title: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between'
    },
    heading: {
        fontSize: theme.typography.pxToRem(15),
    },
    secondaryHeading: {
        fontSize: theme.typography.pxToRem(15),
        color: theme.palette.text.secondary,
    },
    icon: {
        verticalAlign: 'bottom',
        height: 20,
        width: 20,
    },
    details: {
        alignItems: 'center',
    },
    column: {
        flexBasis: '33.33%',
        '& .MuiChip-root': {
            marginRight: 4
        }
    },
    helper: {
        borderLeft: `2px solid ${theme.palette.divider}`,
        padding: theme.spacing(1, 2),
    },
    link: {
        color: theme.palette.primary.main,
        textDecoration: 'none',
        '&:hover': {
            textDecoration: 'underline',
        },
    },
    margin: {
        marginTop: theme.spacing(1),
    },

}));

function Tool() {

    const classes = useStyles();

    const [caches, setCaches] = React.useState(false);

    const [expanded, setExpanded] = React.useState(false);

    const handleChange = (panel) => (event, isExpanded) => {
        setExpanded(isExpanded ? panel : false);
    };

    const useAjax1 = useAjax();

    React.useEffect(() => {
        updateCache({}, true);
    }, []);

    const updateCache = (data) => {

        if (!useAjax1.open) {
            clearCache(useAjax1.ajax, data.key ?? null, (result) => {
                setCaches(result);
            });
        }
    };

    return (
        <SettingGroup
            title={__('Cache')}
            description={
                __('Cache is a hardware or software component that stores data so that future requests for that data can be served faster. {{size}}', {
                    size: caches.totalSize ? '(' + caches.totalSize + ')' : ''
                })
            }
        >
            {
                caches.rows ?
                    Object.keys(caches.rows).map((key) => (
                        <Accordion expanded={expanded === key} onChange={handleChange(key)} key={key}>
                            <AccordionSummary
                                expandIcon={<ExpandMoreIcon />}
                                aria-controls="panel1c-content"
                                id="panel1c-header"
                            >
                                <div className={classes.column}>
                                    <Typography className={classes.heading}>{caches.rows[key].title}</Typography>
                                </div>
                                <div className={classes.column}>
                                    <Typography className={classes.secondaryHeading}>{caches.rows[key].description}</Typography>
                                </div>
                            </AccordionSummary>
                            <AccordionDetails className={classes.details}>
                                <div className={classes.column} />
                                <div className={classes.column}>
                                    {
                                        (() => {
                                            let type = caches.rows[key].type.split(',');
                                            return type.map((item) => (
                                                <Chip key={item} label={item} />
                                            ))
                                        })()
                                    }
                                </div>
                                <div className={classes.column + ' ' + classes.helper}>
                                    <Typography variant="caption">
                                        {caches.rows[key].creator}
                                    </Typography>
                                </div>
                            </AccordionDetails>
                            <Divider />
                            <AccordionActions>
                                <Button
                                    size="small"
                                    color="secondary"
                                    onClick={e => updateCache({ action: 'clear', key: key })}
                                    startIcon={useAjax1.open ? <CircularProgress size={24} color={'inherit'} /> : null}
                                >
                                    {__('Clear')}
                                </Button>
                            </AccordionActions>
                        </Accordion>
                    ))
                    :
                    [...Array(5)].map((e, index) => (
                        <Skeleton key={index} animation="wave" height={48} style={{ marginBottom: 4, width: '100%', transform: 'scale(1)' }} />
                    ))
            }
        </SettingGroup>
    );
}

export default Tool
