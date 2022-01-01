import { Box, Button, Checkbox, Chip, Collapse, FormControlLabel, IconButton, List, ListItem, ListItemText, makeStyles, Paper, Table, TableBody, TableCell, TableContainer, TableHead, TablePagination, TableRow, Typography } from '@material-ui/core';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';
import KeyboardArrowDownIcon from '@material-ui/icons/KeyboardArrowDown';
import KeyboardArrowUpIcon from '@material-ui/icons/KeyboardArrowUp';
import { Skeleton } from '@material-ui/lab';
import { DialogCustom } from 'components';
import NotFound from 'components/NotFound';
import { PageHeaderSticky } from 'components/Page';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { useHistory } from 'react-router-dom';
import { getUrlParams } from 'utils/herlperUrl';
import { __ } from 'utils/i18n';
import { useAjax } from 'utils/useAjax';
import { usePermission } from 'utils/user';

const useStyles = makeStyles((theme) => ({
    root: {
        width: '100%',
        height: '100%',
        display: 'flex',
        flexDirection: 'column',
        justifyContent: 'space-between',
        transition: 'all .15s ease-in',
        '&:hover': {
            opacity: 1,
            background: 'white',
            transform: 'scale(1.02)',
        },
    },
}));

const useRowStyles = makeStyles((theme) => ({
    root: {
        '& > *': {
            borderBottom: 'unset',
        },
    },
    boxContent: {
        maxHeight: 400,
        overflow: 'auto',
        border: '1px solid ' + theme.palette.divider,
        padding: 10,
        wordBreak: 'break-all',
        background: theme.palette.divider,
    }
}));


function LabelLevel({ label }) {

    const confiLabel = {
        all: {
            color: '#8a8a8a'
        },
        emergency: {
            color: 'rgb(141 0 1)',
            icon: 'fa-bug',
            title: __('Emergency'),
        },
        alert: {
            color: '#d32f30',
            icon: 'fa-bell-o',
            title: __('Alert'),
        },
        critical: {
            color: '#f44437',
            icon: 'fa-heartbeat',
            title: __('Critical'),
        },
        error: {
            color: 'rgb(225 75 75)',
            icon: 'fa-times-circle',
            title: __('Error'),
        },
        warning: {
            color: '#CE812E',
            icon: 'fa-exclamation-triangle',
            title: __('Warning'),
        },
        notice: {
            color: '#29B87E',
            icon: 'fa-exclamation-circle',
            title: __('Notice'),
        },
        info: {
            color: '#2E79B4',
            icon: 'fa-exclamation-circle',
            title: __('Info'),
        },
        debug: {
            color: '#90caf8',
            icon: 'fa-globe',
            title: __('Debug'),
        },
        processed: {
            color: '#c658ff',
            icon: 'fa-bug',
            title: __('Processed'),
        },
        failed: {
            color: '#CA2121',
            icon: 'fa-bug',
            title: __('Failed'),
        },
    }
    return <span style={{ padding: '3px 10px', fontSize: 12, borderRadius: '4px', whiteSpace: 'nowrap', background: confiLabel[label].color, color: 'white', textShadow: '1px 1px 3px black' }} >{confiLabel[label].title}</span>
}

function Row(props) {
    const { row } = props;
    const [open, setOpen] = React.useState(false);
    const classes = useRowStyles();

    return (
        <React.Fragment>
            <TableRow className={classes.root} onClick={() => setOpen(!open)}>
                <TableCell>
                    <IconButton aria-label="expand row" size="small">
                        {open ? <KeyboardArrowUpIcon /> : <KeyboardArrowDownIcon />}
                    </IconButton>
                </TableCell>

                <TableCell>
                    <LabelLevel label={row.level} />
                </TableCell>

                <TableCell>
                    {row.context}
                </TableCell>

                <TableCell style={{ whiteSpace: 'nowrap' }}>
                    {row.date}
                </TableCell>

                <TableCell style={{ wordBreak: 'break-all' }}>
                    {row.text}
                </TableCell>
            </TableRow>
            <TableRow>
                <TableCell style={{ paddingBottom: 0, paddingTop: 0 }} colSpan={5}>
                    <Collapse in={open} timeout="auto" unmountOnExit>
                        <Box margin={1}>
                            <Typography component="h3" variant="h3">{__('Detail')}</Typography>
                            <div className={classes.boxContent + ' custom_scroll'} >
                                {row.stack.split('\n').map((str, index) => <p key={index}>{str}</p>)}
                            </div>
                        </Box>
                    </Collapse>
                </TableCell>
            </TableRow>
        </React.Fragment>
    );
}

export default function Log() {

    const classes = useStyles();

    const [data, setData] = React.useState(null);

    const [fileDetail, setFileDetail] = React.useState(getUrlParams(window.location.search, 'l'));

    const [confirmDelete, setConfirmDelete] = React.useState(0);

    const [dialog, setDialog] = React.useState({
        open: false,
    })

    const [page, setPage] = React.useState(0);
    const [rowsPerPage, setRowsPerPage] = React.useState(25);
    const permission = usePermission('log_management').log_management;
    const [filesLogSelected, setFilesLogSelected] = React.useState([]);
    const history = useHistory();

    const handleChangePage = (event, newPage) => {
        setPage(newPage);
    };

    const handleChangeRowsPerPage = (event) => {
        setRowsPerPage(+event.target.value);
        setPage(0);
    };

    const closeDialogConfirmDelete = () => {
        setConfirmDelete(0);
    };

    const { ajax } = useAjax();

    const loadData = (data, calback = null) => {
        ajax({
            url: 'log/get',
            method: 'POST',
            data: data,
            success: (result) => {

                if (result.files) {
                    setPage(0);
                    setData(result);
                }

                setFilesLogSelected([]);

            },
            finally: () => {
                if (calback) {
                    calback();
                }
            }
        });
    };

    const handleConfirmDelete = () => {
        loadData(
            {
                l: fileDetail,
                del: confirmDelete
            },
            () => {
                closeDialogConfirmDelete();
            }
        );
    }

    React.useEffect(() => {

        if (permission) {
            loadData({
                l: fileDetail
            });

            if (fileDetail)
                history.push("?l=" + fileDetail);
        }

    }, [fileDetail]);

    const handleChangeLogSelected = (file) => {

        const index = filesLogSelected.indexOf(file);

        if (index > -1) {
            filesLogSelected.splice(index, 1);
        } else {
            filesLogSelected.push(file);
        }

        setFilesLogSelected([...filesLogSelected]);
    }

    const handelSelectAllFileLog = () => {
        let fileSelected;
        if (data.files.length > 0 && filesLogSelected.length !== data.files.length) {
            fileSelected = data.files.map(({ crypt }) => crypt);
        } else {
            fileSelected = [];
        }
        setFilesLogSelected([...fileSelected]);
    }

    if (!permission) {
        return <RedirectWithMessage />;
    }

    if (!data) {
        return (
            <PageHeaderSticky
                className={classes.main} title={__('Appearance')}
                header={
                    <>
                        <Typography component="h2" gutterBottom variant="overline">{__('Management')}</Typography>
                        <Typography component="h1" variant="h3">{__('System Log')}</Typography>
                    </>
                }
            >
                <TableContainer className="custom_scroll" component={Paper}>
                    <Table stickyHeader aria-label="collapsible sticky table">
                        <TableHead>
                            <TableRow style={{whiteSpace: 'nowrap'}}>
                                <TableCell style={{ width: 25 }} />
                                <TableCell>{__('Level')}</TableCell>
                                <TableCell>{__('Context')}</TableCell>
                                <TableCell>{__('Date time')}</TableCell>
                                <TableCell>{__('Content')}</TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>

                            {
                                [...Array(10)].map((k, i) => (
                                    <TableRow key={i}>
                                        <TableCell><Skeleton animation="wave" height={16} style={{ width: 25, transform: 'scale(1, 1)' }} /></TableCell>
                                        <TableCell><Skeleton animation="wave" height={16} style={{ width: '100%', transform: 'scale(1, 1)' }} /></TableCell>
                                        <TableCell><Skeleton animation="wave" height={16} style={{ width: '100%', transform: 'scale(1, 1)' }} /></TableCell>
                                        <TableCell><Skeleton animation="wave" height={16} style={{ width: '100%', transform: 'scale(1, 1)' }} /></TableCell>
                                        <TableCell><Skeleton animation="wave" height={16} style={{ width: '100%', transform: 'scale(1, 1)' }} /></TableCell>
                                    </TableRow>
                                ))
                            }
                        </TableBody>
                    </Table>
                </TableContainer>

            </PageHeaderSticky>
        );
    }

    return (
        <PageHeaderSticky
            className={classes.main} title={__('Appearance')}
            header={
                <>
                    <Typography component="h2" gutterBottom variant="overline">{__('Management')}</Typography>
                    <Typography component="h1" variant="h3">{__('System Log')}
                        {
                            data.files?.length > 0 &&
                            <Chip
                                style={{ marginLeft: 8, background: '#546e7a', color: 'white' }}
                                label={Boolean(data.current_file) && data.current_file}
                                clickable
                                color="default"
                                onClick={() => { setDialog({ ...dialog, open: true }); console.log(filesLogSelected); }}
                            />
                        }
                    </Typography>
                </>
            }
        >
            <DialogCustom
                open={dialog.open && data.files?.length && confirmDelete === 0}
                onClose={() => setDialog({ ...dialog, open: false })}
                title={'Files Log ' + (filesLogSelected.length > 0 ? '[' + filesLogSelected.length + ']' : '')}
                action={<div style={{ display: 'flex', justifyContent: 'space-between', width: '100%', paddingLeft: 32 }}>
                    <div>
                        <FormControlLabel
                            style={{ marginRight: 0 }}
                            control={
                                <Checkbox
                                    checked={filesLogSelected.length === data.files.length}
                                    color="primary"
                                    indeterminate={
                                        filesLogSelected.length > 0 &&
                                        filesLogSelected.length < data.files.length
                                    }
                                    onClick={handelSelectAllFileLog}
                                />
                            }
                            label={'Select all [' + data.files.length + ']'}
                        />
                    </div>
                    <div>
                        {
                            filesLogSelected.length > 0 &&
                            <Button color="secondary" onClick={(e) => { e.stopPropagation(); setConfirmDelete(filesLogSelected); }}>{__('Delete')}</Button>

                        }
                        <Button onClick={() => setDialog({ ...dialog, open: false })}>{__('Cancel')}</Button>
                    </div>
                </div>
                }
            >
                <List>
                    {data.files.map((file) => (
                        <ListItem selected={file.title === data.current_file} onClick={() => { setFileDetail(file.crypt); setDialog({ ...dialog, open: false }); }} button key={file.crypt}>
                            <FormControlLabel
                                style={{ marginRight: 0 }}
                                control={
                                    <Checkbox
                                        checked={filesLogSelected.indexOf(file.crypt) > -1}
                                        onChange={() => handleChangeLogSelected(file.crypt)}
                                        onClick={e => e.stopPropagation()}
                                        name="checkedB"
                                        color="primary"
                                    />
                                }
                            />
                            <ListItemText primary={file.title} />
                            <span style={{ margin: ' 0 8px' }}>{file.date}</span>
                            <IconButton onClick={(e) => { e.stopPropagation(); setConfirmDelete(file.crypt); }} size="small" aria-label="Delete" component="span">
                                <DeleteRoundedIcon />
                            </IconButton>
                        </ListItem>
                    ))}
                </List>
            </DialogCustom>

            <DialogCustom
                title="Confirm Deletion"
                open={Boolean(confirmDelete !== 0)}
                onClose={closeDialogConfirmDelete}
                action={
                    <>
                        <Button onClick={handleConfirmDelete} color="default">{__('OK')}</Button>
                        <Button onClick={closeDialogConfirmDelete} color="primary" autoFocus>{__('Cancel')}</Button>
                    </>
                }
            >
                {__('Are you sure you want to permanently remove this item?')}
            </DialogCustom>



            {
                data.logs.length ?
                    <Typography color="textSecondary" gutterBottom variant="body2">
                        {
                            __('{{total}} Records found. Page {{current_page}} of {{total_page}}', {
                                total: data.logs.length,
                                current_page: page + 1,
                                total_page: Math.ceil(data.logs.length / rowsPerPage * 1)
                            })
                        }
                    </Typography>
                    :
                    <Typography color="textSecondary" gutterBottom variant="body2">
                        &nbsp;
                    </Typography>
            }
            {
                data.logs.length ?
                    <>
                        <TableContainer className="custom_scroll" component={Paper}>
                            <Table stickyHeader aria-label="collapsible sticky table">
                                <colgroup>
                                    <col width="10px" />
                                    <col width="10px" />
                                    <col width="10px" />
                                    <col width="10px" />
                                    <col width="60%" />
                                </colgroup>
                                <TableHead>
                                    <TableRow style={{whiteSpace: 'nowrap'}}>
                                        <TableCell />
                                        <TableCell>{__('Level')}</TableCell>
                                        <TableCell>{__('Context')}</TableCell>
                                        <TableCell>{__('Date time')}</TableCell>
                                        <TableCell>{__('Content')}</TableCell>
                                    </TableRow>
                                </TableHead>
                                <TableBody>
                                    {
                                        data.logs.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage).map((log, index) => (
                                            <Row key={index} row={log} />
                                        ))
                                    }
                                </TableBody>
                            </Table>
                        </TableContainer>
                        <TablePagination
                            rowsPerPageOptions={[10, 25, 100]}
                            component="div"
                            count={data.logs.length}
                            rowsPerPage={rowsPerPage}
                            page={page}
                            onChangePage={handleChangePage}
                            onChangeRowsPerPage={handleChangeRowsPerPage}
                            labelRowsPerPage={__('Rows per page:')}
                            labelDisplayedRows={({ from, to, count }) => `${from} - ${to} ${__('of')} ${count !== -1 ? count : `${__('more than')} ${to}`}`}

                        />
                    </>
                    :
                    <NotFound />
            }

        </PageHeaderSticky>
    )
}

