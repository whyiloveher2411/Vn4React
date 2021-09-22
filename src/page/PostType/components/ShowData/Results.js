import { Box, Button, Card, CardActions, CardContent, CardHeader, Checkbox, CircularProgress, Divider, IconButton, Table, TableBody, TableCell, TableHead, TablePagination, TableRow, Tooltip, Typography } from '@material-ui/core';
import StarBorderOutlinedIcon from '@material-ui/icons/StarBorderOutlined';
import StarOutlinedIcon from '@material-ui/icons/StarOutlined';
import { makeStyles } from '@material-ui/styles';
import { ActionPost, DialogCustom, DrawerEditPost, FieldView, GenericMoreButton, NotFound, TableEditBar } from 'components';
import React, { useState } from 'react';
import { useAjax } from 'utils/useAjax';
import LabelPost from '../LabelPost';
import FilterGroup from './FilterGroup';

const useStyles = makeStyles((theme) => ({
    root: {
        paddingBottom: 56,
    },
    results: {
        marginTop: theme.spacing(3),
    },
    cardWarper: {
        position: 'relative',
        '&>.MuiCardHeader-root>.MuiCardHeader-action': {
            margin: 0
        }
    },
    cardHeader: {
        padding: 0,
        '& .MuiCardHeader-action': {
            alignSelf: 'center'
        }
    },
    showLoading: {
        '&::before': {
            display: 'inline-block',
            content: '""',
            position: 'absolute',
            left: 0,
            right: 0,
            bottom: 0,
            top: 0,
            background: 'rgba(0, 0, 0, 0.1)',
            zIndex: 1,
        }
    },
    content: {
        padding: 0,
    },
    actions: {
        padding: theme.spacing(1),
        justifyContent: 'flex-end',
    },
    iconLoading: {
        position: 'absolute',
        zIndex: 2,
        top: 'calc(50% - 20px)',
        left: 'calc(50% - 20px)',
    },
    iconStar: {
        width: 40,
        height: 40,
        opacity: 0.7,
        '&:hover': {
            opacity: 1
        }
    },
    trRowAction: {
        position: 'relative',
    },
    pad8: {
        paddingLeft: 8,
        paddingRight: 8,
    },
    rowRecord: {
        cursor: 'pointer',
        '&:hover': {
            '& .actionPost': {
                opacity: 1
            }
        },
        '&>td': {
            padding: 8
        },
        '&>.MuiTableCell-paddingCheckbox': {
            padding: '0 0 0 4px'
        }
    },
}))

const Results = (props) => {

    const { result, onFilter, postType, loading, value, queryUrl, setQueryUrl, isLoadedData, history, acctionPost, ...rest } = props

    const rows = result.rows ?? { };
    const options = result.config ?? { };

    const data = rows?.data ?? [];

    const classes = useStyles();

    const [selectedCustomers, setSelectedCustomers] = useState([]);

    const [confirmDelete, setConfirmDelete] = React.useState(0);

    const { ajax, Loading, setOpen, open } = useAjax();

    const [openDrawer, setOpenDrawer] = React.useState(false);
    const [dataDrawer, setDataDrawer] = React.useState(false);



    const closeDialogConfirmDelete = () => {
        setConfirmDelete(0);
    };

    const [render, setRender] = useState(0);

    const handleOnClickSelectAll = () => {

        if (selectedCustomers.length === 0) {
            setSelectedCustomers(data.map((customer) => customer.id))
        } else {
            if (selectedCustomers.length === data.length) {
                setSelectedCustomers([]);
            } else {
                setSelectedCustomers(data.map((customer) => customer.id))
            }
        }

    }

    React.useEffect(() => {
        setSelectedCustomers([]);
    }, [postType]);

    const handleSelectOne = (event, id) => {

        const selectedIndex = selectedCustomers.indexOf(id)
        let newSelectedCustomers = []

        if (selectedIndex === -1) {
            newSelectedCustomers = newSelectedCustomers.concat(
                selectedCustomers,
                id
            )
        } else if (selectedIndex === 0) {
            newSelectedCustomers = newSelectedCustomers.concat(
                selectedCustomers.slice(1)
            )
        } else if (selectedIndex === selectedCustomers.length - 1) {
            newSelectedCustomers = newSelectedCustomers.concat(
                selectedCustomers.slice(0, -1)
            )
        } else if (selectedIndex > 0) {
            newSelectedCustomers = newSelectedCustomers.concat(
                selectedCustomers.slice(0, selectedIndex),
                selectedCustomers.slice(selectedIndex + 1)
            )
        }

        setSelectedCustomers(newSelectedCustomers)
    }

    const handleClickOne = e => {
        e.stopPropagation();
    };

    const handleChangePage = (event, v) => {
        setQueryUrl({ ...queryUrl, page: v + 1 });
        setRender(render + 1);
    }

    const handleChangeRowsPerPage = (event) => {
        setQueryUrl({ ...queryUrl, rowsPerPage: event.target.value });
        setRender(render + 1);
    }

    const actionLiveEdit = (key, value, post) => {
        ajax({
            url: 'post-type/post-inline-edit',
            data: {
                post: post,
                key: key,
                value: value,
            },
            success: (result) => {
                console.log(result);
            }
        });

    };

    const handleSubmit = () => {

        if (!open) {
            ajax({
                url: 'post-type/post/' + dataDrawer.type,
                method: 'POST',
                data: { ...dataDrawer.post, _action: 'EDIT' },
                isGetData: false,
                success: (result) => {
                    if (result.post?.id) {
                        setOpenDrawer(false);
                        setQueryUrl({ ...queryUrl });
                    }
                }
            });
        }
    }

    const eventClickRow = (e, id) => {

        history.push(`/post-type/${postType}/edit?post_id=${id}`);

        return;


        // setOpen(true);
        // // console.log(data);
        // ajax({
        //     url: `post-type/detail/${postType}/${id}`,
        //     method: 'POST',
        //     isGetData: false,
        //     success: function (result) {
        //         if (result.post) {
        //             result.type = postType;
        //             result.updatePost = new Date();
        //             setDataDrawer(prev => ({ ...result }));
        //             setOpenDrawer(true);
        //         }
        //     }
        // });

    };


    let keyFields;

    return (
        <div {...rest} className={classes.root + ' ' + classes.results}>
            {
                rows.total ?
                    <Typography color="textSecondary" gutterBottom variant="body2">
                        {rows.total} Records found. Page {rows.current_page} of{' '}
                        {Math.ceil(rows.total / rows.per_page * 1)}
                    </Typography>
                    :
                    <Typography color="textSecondary" gutterBottom variant="body2">
                        &nbsp;
                    </Typography>
            }
            <Card className={classes.cardWarper + ' ' + (loading ? classes.showLoading : '')}>
                <CardHeader
                    className={classes.cardHeader}
                    action={<GenericMoreButton
                        action={[
                            {
                                import: {
                                    title: 'Import',
                                    icon: 'PublishRounded',
                                    action: () => { alert('Coming sooon.')}
                                },
                                export: {
                                    title: 'Export',
                                    icon: 'GetAppRounded',
                                    action: () => { alert('Coming sooon.')}
                                },
                            },
                            {
                                columns: {
                                    title: 'Columns',
                                    icon: 'SettingsOutlined',
                                    action: () => { alert('Coming sooon.')}
                                }
                            }
                        ]}
                    />}
                    title={<FilterGroup acctionPost={acctionPost} queryUrl={queryUrl} data={result} onFilter={onFilter} setQueryUrl={setQueryUrl} options={options} />}
                />
                <Divider />
                <CardContent className={classes.content}>
                    <Table>
                        <TableHead>
                            <TableRow>
                                <TableCell padding="checkbox">
                                    {
                                        rows.total ?
                                            <Checkbox
                                                checked={
                                                    Boolean(selectedCustomers.length ===
                                                        rows.total && rows.total)
                                                }
                                                color="primary"
                                                indeterminate={
                                                    selectedCustomers.length > 0 &&
                                                    selectedCustomers.length < rows.total
                                                }
                                                onClick={handleOnClickSelectAll}
                                            />
                                            : <></>
                                    }
                                </TableCell>
                                <TableCell padding="checkbox">

                                </TableCell>
                                {options.fields &&
                                    Object.keys(options.fields).map(key => (
                                        (options.fields[key].show_data !== false || options.fields[key].show_data === undefined)
                                            ?
                                            <TableCell className={classes.pad8} key={key}>{options.fields[key].title}</TableCell>
                                            :
                                            <React.Fragment key={key}></React.Fragment>
                                    ))
                                }
                                <TableCell padding="checkbox"></TableCell>
                            </TableRow>
                        </TableHead>
                        <TableBody>
                            {data && data[0] ?
                                data.map((customer) => (
                                    <TableRow
                                        hover
                                        onClick={e => eventClickRow(e, customer.id)}
                                        data-id={customer.id}
                                        key={customer.id}
                                        className={classes.rowRecord}
                                        selected={
                                            selectedCustomers.indexOf(
                                                customer.id
                                            ) !== -1
                                        }>
                                        <TableCell padding="checkbox">
                                            <Tooltip title="Select" aria-label="select">
                                                <Checkbox
                                                    checked={
                                                        selectedCustomers.indexOf(
                                                            customer.id
                                                        ) !== -1
                                                    }
                                                    color="primary"
                                                    onChange={(event) =>
                                                        handleSelectOne(
                                                            event,
                                                            customer.id
                                                        )
                                                    }
                                                    onClick={handleClickOne}
                                                    value={
                                                        selectedCustomers.indexOf(
                                                            customer.id
                                                        ) !== -1
                                                    }
                                                />
                                            </Tooltip>
                                        </TableCell>
                                        <TableCell padding="checkbox">
                                            <Tooltip title={customer.starred ? 'Starred' : 'Not starred'} aria-label="Star">
                                                <IconButton
                                                    onClick={(e) => { e.stopPropagation(); acctionPost({ starred: { post: customer.id, value: !customer.starred } }); }}
                                                    color="default"
                                                    className={classes.iconStar}
                                                    aria-label="Back"
                                                    component="span">
                                                    {
                                                        customer.starred
                                                            ?
                                                            <StarOutlinedIcon style={{ color: '#f4b400' }} />
                                                            :
                                                            <StarBorderOutlinedIcon />
                                                    }
                                                </IconButton>
                                            </Tooltip>
                                        </TableCell>
                                        {
                                            (keyFields = Object.keys(options.fields)) &&
                                            keyFields.map(key => (
                                                (options.fields[key].show_data !== false || options.fields[key].show_data === undefined)
                                                    ?
                                                    key === keyFields[0] ?
                                                        <TableCell key={key} className={classes.trRowAction}>
                                                            <Box display="flex" alignItems="center" >
                                                                <FieldView name={key} compoment={options.fields[key].view} post={customer} config={options.fields[key]} content={customer[key]} actionLiveEdit={actionLiveEdit} />
                                                                <LabelPost post={customer} />
                                                                {
                                                                    (() => {
                                                                        if (customer.is_homepage) {
                                                                            try {
                                                                                let label = JSON.parse(customer.is_homepage);

                                                                                if (label) {
                                                                                    return <strong>&nbsp;- {label.title}</strong>;
                                                                                }
                                                                            } catch (error) {
                                                                                return null;
                                                                            }
                                                                        }
                                                                    })()
                                                                }
                                                            </Box>
                                                        </TableCell>
                                                        :
                                                        <TableCell key={key}>
                                                            <FieldView name={key} compoment={options.fields[key].view} config={options.fields[key]} post={customer} content={customer[key]} actionLiveEdit={actionLiveEdit} />
                                                        </TableCell>
                                                    :
                                                    <React.Fragment key={key}></React.Fragment>
                                            ))
                                        }
                                        <TableCell>
                                            <ActionPost fromLayout="list" history={history} setConfirmDelete={setConfirmDelete} acctionPost={acctionPost} post={customer} postType={postType} />
                                        </TableCell>
                                    </TableRow>
                                ))
                                :
                                (isLoadedData ?
                                    <TableRow>
                                        <TableCell colSpan={100}>
                                            <NotFound>
                                                Nothing To Display. <br />
                                                <span style={{ color: '#ababab', fontSize: '16px' }}>Seems like no {result.config?.label?.singularName ?? 'Data'} have been created yet.</span>
                                            </NotFound>
                                        </TableCell>
                                    </TableRow>
                                    :
                                    <TableRow>
                                        <TableCell colSpan={100}>
                                            <NotFound>
                                                Loading...
                                            </NotFound>
                                        </TableCell>
                                    </TableRow>
                                )
                            }
                        </TableBody>
                    </Table>
                </CardContent>
                <CardActions className={classes.actions}>

                    <TablePagination
                        component="div"
                        count={rows.total ? rows.total * 1 : 0}
                        onChangePage={handleChangePage}
                        onChangeRowsPerPage={handleChangeRowsPerPage}
                        page={rows.current_page ? rows.current_page - 1 : 0}
                        rowsPerPage={rows.per_page ? rows.per_page * 1 : 10}
                        rowsPerPageOptions={[10, 25, 50, 100]}
                    />
                </CardActions>
                {loading && <CircularProgress value={75} className={classes.iconLoading} />}
            </Card>
            <TableEditBar acctionPost={acctionPost} selected={selectedCustomers} setSelectedCustomers={setSelectedCustomers} />

            <DrawerEditPost
                open={openDrawer}
                onClose={() => setOpenDrawer(false)}
                data={dataDrawer}
                handleSubmit={handleSubmit}
                showLoadingButton={open}
            />

            <DialogCustom
                open={Boolean(confirmDelete !== 0)}
                onClose={closeDialogConfirmDelete}
                aria-labelledby="alert-dialog-title"
                aria-describedby="alert-dialog-description"
                title="Confirm Deletion"
                action={
                    <>
                        <Button onClick={() => { acctionPost({ delete: [confirmDelete] }); closeDialogConfirmDelete(); }} color="default">
                            OK
                        </Button>
                        <Button onClick={closeDialogConfirmDelete} color="primary" autoFocus>
                            Cancel
                        </Button>
                    </>
                }
            >
                Are you sure you want to permanently remove this item?
            </DialogCustom>

            {Loading}
        </div >
    )
}

export default Results
