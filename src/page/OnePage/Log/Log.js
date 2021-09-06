import { Box, Button, Checkbox, Chip, Collapse, colors, FormControlLabel, IconButton, List, ListItem, ListItemText, makeStyles, Paper, Table, TableBody, TableCell, TableContainer, TableHead, TablePagination, TableRow, Typography } from '@material-ui/core';
import DeleteRoundedIcon from '@material-ui/icons/DeleteRounded';
import KeyboardArrowDownIcon from '@material-ui/icons/KeyboardArrowDown';
import KeyboardArrowUpIcon from '@material-ui/icons/KeyboardArrowUp';
import { Skeleton } from '@material-ui/lab';
import { DialogCustom, Page } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { useHistory } from 'react-router-dom';
import { getUrlParams } from 'utils/herlperUrl';
import { useAjax } from 'utils/useAjax';
import { checkPermission } from 'utils/user';
import NotFound from 'components/NotFound';

const useStyles = makeStyles((theme) => ({
    grid: {
        marginTop: 16
    },
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
            '& $byVersion': {
                display: 'flex'
            }
        },
        '& a, & .link': {
            color: '#337ab7',
            fontSize: 13,
            cursor: 'pointer',
            textAlign: 'center',
        }
    },
    byVersion: {
        fontSize: 13,
        display: 'none',
        position: 'absolute',
        top: 8,
        width: '100%',
        justifyContent: 'space-between',
        padding: '0 16px',
        fontWeight: 500,

    },
    notActive: {
        opacity: 0.5,
        background: 'transparent',
    },
    media: {
        height: 160,
    },
    description: {
        fontSize: 12,
        lineHeight: '16px',
        letterSpacing: 'normal',
        overflowWrap: 'normal',
        display: '-webkit-box',
        textOverflow: 'ellipsis',
        overflow: 'hidden',
        '-webkit-line-clamp': 3,
        '-webkit-box-orient': 'vertical',
        color: 'rgb(96, 103, 112)',
        height: 48,
        maxWidth: 280,
    },
    saveButton: {
        color: theme.palette.white,
        backgroundColor: colors.green[600],
        '&:hover': {
            backgroundColor: colors.green[900],
        },
    },
}));

const useRowStyles = makeStyles({
    root: {
        '& > *': {
            borderBottom: 'unset',
        },
    },
    boxContent: {
        maxHeight: 400,
        overflow: 'auto',
        border: '1px solid #dedede',
        padding: 10,
        wordBreak: 'break-all',
        background: '#eeeeee',
    }
});


function LabelLevel({ label }) {

    const confiLabel = {
        all: {
            color: '#8a8a8a'
        },
        emergency: {
            color: 'rgb(141 0 1)',
            icon: 'fa-bug',
        },
        alert: {
            color: '#d32f30',
            icon: 'fa-bell-o',
        },
        critical: {
            color: '#f44437',
            icon: 'fa-heartbeat',
        },
        error: {
            color: 'rgb(225 75 75)',
            icon: 'fa-times-circle',
        },
        warning: {
            color: '#CE812E',
            icon: 'fa-exclamation-triangle',
        },
        notice: {
            color: '#29B87E',
            icon: 'fa-exclamation-circle',
        },
        info: {
            color: '#2E79B4',
            icon: 'fa-exclamation-circle',
        },
        debug: {
            color: '#90caf8',
            icon: 'fa-globe',
        },
        processed: {
            color: '#c658ff',
            icon: 'fa-bug',
        },
        failed: {
            color: '#CA2121',
            icon: 'fa-bug',
        },
    }
    return <span style={{ padding: '3px 10px', fontSize: 12, borderRadius: '4px', background: confiLabel[label].color, color: 'white', textShadow: '1px 1px 3px black' }} >{label}</span>
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
                            <Typography component="h3" variant="h3">Detail</Typography>
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
    const permission = checkPermission('log_management');
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
            <Page className={classes.main} title="Appearance">
                <div>
                    <Typography component="h2" gutterBottom variant="overline">Management</Typography>
                    <Typography component="h1" variant="h3">System Log</Typography>
                </div>
                <br />
                <Typography color="textSecondary" gutterBottom variant="body2">
                    &nbsp;
                </Typography>
                <TableContainer className="custom_scroll" component={Paper}>
                    <Table stickyHeader aria-label="collapsible sticky table">
                        <TableHead>
                            <TableRow>
                                <TableCell style={{ width: 25 }} />
                                <TableCell>Level</TableCell>
                                <TableCell>Context</TableCell>
                                <TableCell>Date</TableCell>
                                <TableCell>Content</TableCell>
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

            </Page>
        );
    }

    return (

        <Page className={classes.main} title="System Log">
            <div>
                <Typography component="h2" gutterBottom variant="overline">Management</Typography>
                <Typography component="h1" variant="h3">System Log
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
            </div>
            <br />

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
                            <Button color="secondary" onClick={(e) => { e.stopPropagation(); setConfirmDelete(filesLogSelected); }}>Delete</Button>

                        }
                        <Button onClick={() => setDialog({ ...dialog, open: false })}>Cancel</Button>
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
                        <Button onClick={handleConfirmDelete} color="default">OK</Button>
                        <Button onClick={closeDialogConfirmDelete} color="primary" autoFocus>Cancel</Button>
                    </>
                }
            >
                Are you sure you want to permanently remove this item?
            </DialogCustom>



            {
                data.logs.length ?
                    <Typography color="textSecondary" gutterBottom variant="body2">
                        {data.logs.length} Records found. Page {page + 1} of{' '}
                        {Math.ceil(data.logs.length / rowsPerPage * 1)}
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
                                    <TableRow>
                                        <TableCell />
                                        <TableCell>Level</TableCell>
                                        <TableCell>Context</TableCell>
                                        <TableCell>Date</TableCell>
                                        <TableCell>Content</TableCell>
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
                        />
                    </>
                    :
                    <NotFound>
                        Nothing To Display. <br />
                        <span style={{ color: '#ababab', fontSize: '16px' }}>Seems like no Data have been created yet.</span>
                    </NotFound>
                // <Typography style={{ textAlign: 'center', margin: '10rem 0' }} component="h2" variant="h2">Not found result.</Typography>
            }


        </Page>
    )
}

