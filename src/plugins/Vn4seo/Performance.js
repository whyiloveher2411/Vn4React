import { Chip, Collapse, FormControl, FormControlLabel, Grid, InputLabel, makeStyles, MenuItem, Radio, RadioGroup, Select, Typography } from '@material-ui/core';
import Button from '@material-ui/core/Button';
import Dialog from '@material-ui/core/Dialog';
import DialogActions from '@material-ui/core/DialogActions';
import DialogContent from '@material-ui/core/DialogContent';
import DialogContentText from '@material-ui/core/DialogContentText';
import DialogTitle from '@material-ui/core/DialogTitle';
import CreateIcon from '@material-ui/icons/Create';
import HighlightOffIcon from '@material-ui/icons/HighlightOff';
import { Alert } from '@material-ui/lab';
import { FieldForm } from 'components';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { useSelector } from 'react-redux';
import { getCookie, setCookie } from 'utils/cookie';
import { usePermission } from 'utils/user';
import ChartDate from './compoments/Performance/ChartDate';
import Detail from './compoments/Performance/Detail';


const useStyles = makeStyles((theme) => ({
    disableOutline: {
        "& .Mui-focused .MuiOutlinedInput-notchedOutline": {
            border: "1px solid #484850",
            borderRadius: "5px 5px 0 0"
        },
    },
    alert: {
        marginBottom: 16,
        '& .alert-content': {
            display: 'flex'
        },
        '& .MuiAlert-icon': {
            paddingTop: 10,
        }
    },
    removeAlert: {
        opacity: 0.54,
        marginLeft: 5,
        cursor: 'pointer',
        '&:hover': {
            opacity: 1
        }
    }
}));


const getFormatDateApi = (date) => {
    if (date instanceof Date) {
        return date.getFullYear() + '-' + (('0' + (date.getMonth() + 1)).slice(-2)) + '-' + (('0' + date.getDate()).slice(-2));
    }
    return date;
};


function Performance({ ajaxPluginHandle }) {

    const classes = useStyles();

    const settings = useSelector(state => state.settings);
    const config = settings['seo/analytics/google_search_console'] ?? {};

    const [date, setDate] = React.useState({ index: 2, count: 0 });
    const [dateInput, setDateInput] = React.useState(2);
    const [hideAlert, setHideAlert] = React.useState(getCookie('vn4seoHideAlert'));
    const permission = usePermission('plugin_vn4seo_view_performance').plugin_vn4seo_view_performance;


    const [dateInputCustom, setDateInputCustom] = React.useState((() => {
        let d = new Date(), startDay = new Date();
        d.setDate(d.getDate() - 3);
        startDay.setDate(startDay.getDate() - 3);
        startDay.setMonth(d.getMonth() - 3);
        return { date_0: getFormatDateApi(startDay), date_1: getFormatDateApi(d), open: false };
    })());

    const labelDateFilter = [
        {
            id: 'last7Days',
            title: 'Last 7 days',
            date: () => {
                let d = new Date(), dayEnd = new Date();
                d.setDate(d.getDate() - 3);
                dayEnd.setDate(dayEnd.getDate() - 3);
                dayEnd.setDate(d.getDate() - 7);
                return [getFormatDateApi(d), getFormatDateApi(dayEnd)];
            }
        },
        {
            id: 'last28Days',
            title: 'Last 28 days',
            date: () => {
                let d = new Date(), dayEnd = new Date();
                d.setDate(d.getDate() - 3);
                dayEnd.setDate(dayEnd.getDate() - 3);
                dayEnd.setDate(d.getDate() - 28);
                return [getFormatDateApi(d), getFormatDateApi(dayEnd)];
            }
        },
        {
            id: 'last3Months',
            title: 'Last 3 months',
            date: () => {
                let d = new Date(), dayEnd = new Date();
                d.setDate(d.getDate() - 3);
                dayEnd.setDate(dayEnd.getDate() - 3);
                dayEnd.setMonth(d.getMonth() - 3);
                return [getFormatDateApi(d), getFormatDateApi(dayEnd)];
            }
        },
        {
            id: 'last6Months',
            title: 'Last 6 months',
            date: () => {
                let d = new Date(), dayEnd = new Date();
                d.setDate(d.getDate() - 3);
                dayEnd.setDate(dayEnd.getDate() - 3);
                dayEnd.setMonth(d.getMonth() - 6);
                return [getFormatDateApi(d), getFormatDateApi(dayEnd)];
            }
        },
        {
            id: 'last12Months',
            title: 'Last 12 months',
            date: () => {
                let d = new Date(), dayEnd = new Date();
                d.setDate(d.getDate() - 3);
                dayEnd.setDate(dayEnd.getDate() - 3);
                dayEnd.setMonth(d.getMonth() - 12);
                return [getFormatDateApi(d), getFormatDateApi(dayEnd)];
            }
        },
        {
            id: 'last16Months',
            title: 'Last 16 months',
            date: () => {
                let d = new Date(), dayEnd = new Date();
                d.setDate(d.getDate() - 3);
                dayEnd.setDate(dayEnd.getDate() - 3);
                dayEnd.setMonth(d.getMonth() - 16);
                return [getFormatDateApi(d), getFormatDateApi(dayEnd)];
            }
        },
        {
            id: 'custom',
            title: 'Custom',
            date: () => {
                return [getFormatDateApi(dateInputCustom.date_1), getFormatDateApi(dateInputCustom.date_0)];
            }
        }
    ];

    const [openDialog, setOpenDialog] = React.useState(false);

    const [openDialogDate, setOpenDialogDate] = React.useState(false);

    const handleClickOpen = () => {
        setOpenDialog(true);
        setDateInput(date.index);
    };

    const handleClose = () => {
        setOpenDialog(false);
    };

    const applyDateRange = () => {
        setDate({ count: date.count + 1, index: dateInput }); handleClose();
    };

    if (!settings._loaded) {
        return <></>
    }

    if (!permission) {
        return <RedirectWithMessage />
    }

    if (!settings['seo/analytics/google_search_console/active'] || !config.complete_installation) {
        return <RedirectWithMessage
            message="Please install google analytics before using this feature!"
            to="/settings/seo/search-console"
            variant="warning" />
    }

    return (
        <PageHeaderSticky
            title="SEO Performance"
            header={
                <Grid
                    container
                    className={classes.grid}
                    justify="space-between"
                    alignItems="center"
                    spacing={3}>
                    <Grid item xs={12}>
                        <Typography component="h2" gutterBottom variant="overline">Vn4 SEO</Typography>
                        <Typography component="div" variant="h3">
                            <div>
                                Performance
                                <Chip
                                    style={{ marginLeft: 8, background: '#546e7a', color: 'white' }}
                                    label={'Date: ' + (date.index !== (labelDateFilter.length - 1) ? labelDateFilter[date.index].title : (() => {
                                        let days = labelDateFilter[date.index].date();
                                        let dayStart = new Date(days[1]), dayEnd = new Date(days[0]);
                                        let monthNames = ["Jan", "Feb", "Mar", "Apr", "May", "June",
                                            "July", "Aug", "Sept", "Oct", "Nov", "Dec"
                                        ];
                                        return monthNames[dayStart.getMonth()] + ' ' + dayStart.getDate() + ', ' + dayStart.getFullYear() + ' - ' + monthNames[dayEnd.getMonth()] + ' ' + dayEnd.getDate() + ', ' + dayEnd.getFullYear();

                                    })())}
                                    clickable
                                    color="default"
                                    onClick={handleClickOpen}
                                    deleteIcon={<CreateIcon style={{ color: 'white' }} />}
                                    onDelete={handleClickOpen}
                                />

                                <Dialog
                                    open={openDialog}
                                    onClose={() => { setOpenDialog(false) }}
                                    scroll='paper'
                                    maxWidth='xs'
                                    aria-labelledby="scroll-dialog-title"
                                    aria-describedby="scroll-dialog-description"
                                    fullWidth
                                    className={classes.disableOutline}
                                >
                                    <DialogTitle disableTypography={true} style={{ fontSize: 22, background: '#455a64', color: 'white' }}>Date range</DialogTitle>
                                    <DialogContent dividers={true}>
                                        <DialogContentText
                                            component="div"
                                        >
                                            <RadioGroup value={dateInput} onChange={(e) => { setDateInput(e.target.value * 1) }}>
                                                {
                                                    labelDateFilter.map((item, i) => (
                                                        <FormControlLabel key={i} value={i} control={<Radio />} label={item.title} />
                                                    ))
                                                }
                                            </RadioGroup>
                                            <div
                                                style={dateInput === (labelDateFilter.length - 1) ? {} : { opacity: 0.54 }}
                                                onClick={(e) => {
                                                    e.stopPropagation();
                                                    if (dateInput !== (labelDateFilter.length - 1)) {
                                                        setDateInput(labelDateFilter.length - 1);
                                                    }
                                                }}
                                            >
                                                <FieldForm
                                                    compoment={'date_range'}
                                                    config={{
                                                        title: ''
                                                    }}
                                                    inputProp={{
                                                        inputVariant: "standard"
                                                    }}
                                                    post={dateInputCustom}
                                                    name={'date'}
                                                    onReview={(value, key) => {
                                                        setDateInputCustom(key);
                                                    }}
                                                    open={openDialogDate}
                                                    onOpen={() => setOpenDialogDate(true)}
                                                    onClose={() => { }}
                                                    onAccept={(value) => {
                                                        setDateInputCustom({
                                                            date_0: value[0],
                                                            date_1: value[1],
                                                        });
                                                        setOpenDialogDate(false);
                                                    }}
                                                    disableFuture
                                                />
                                            </div>
                                        </DialogContentText>
                                    </DialogContent>
                                    <DialogActions>
                                        <Button onClick={handleClose}>Cancel</Button>
                                        <Button onClick={applyDateRange} color="primary">Apply</Button>
                                    </DialogActions>
                                </Dialog>
                            </div>
                        </Typography>
                    </Grid>
                </Grid>
            }
        >
            {
                hideAlert === null || hideAlert === true
                    ?
                    <Collapse in={hideAlert === null}>
                        <Alert className={classes.alert} variant="filled" severity="warning"><div className="alert-content">Google delivers the Search Console data through their API with a two to three-day delay. This means that the complete data for the previous week usually become available on Wednesday, at which time we will display it in the toolbox. The data update happens automatically. No activity on your part is necessary.<HighlightOffIcon onClick={() => { setCookie('vn4seoHideAlert', true, 1); setHideAlert(true); }} className={classes.removeAlert} /></div></Alert>
                    </Collapse>
                    :
                    <></>
            }
            <ChartDate ajaxPluginHandle={ajaxPluginHandle} labelDateFilter={labelDateFilter} date={date} />
            <Detail ajaxPluginHandle={ajaxPluginHandle} labelDateFilter={labelDateFilter} date={date} />
        </PageHeaderSticky >
    )
}

export default Performance
