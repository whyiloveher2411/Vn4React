import { Box, Button, makeStyles, Paper, Table, TableBody, TableCell, TableContainer, TableHead, TablePagination, TableRow } from '@material-ui/core';
import { ActionPost, DialogCustom, FieldView, NotFound } from 'components';
import LabelPost from 'page/PostType/components/LabelPost';
import React from 'react';
import { useHistory } from 'react-router-dom';
import { useAjax } from 'utils/useAjax';
import DrawerEditPost from './DrawerEditPost';
import { __ } from 'utils/i18n';

const useStyles = makeStyles(() => ({
    tr: {
        cursor: 'pointer',
        '&:hover': {
            '& .actionPost': {
                opacity: 1
            }
        },
        '&>td': {
            padding: '8px 16px'
        },
        '&>.MuiTableCell-paddingCheckbox': {
            padding: '0 0 0 4px'
        }
    },
    dFlex: {
        display: 'flex',
        alignItems: 'center',
        justifyContent: 'space-between',
        '& .link-edit-post': {
            opacity: 0,
            '&:hover': {
                opacity: 1,
                color: '#337ab7'
            }
        }
    },
}));

function DataTable(props) {

    const classes = useStyles();
    const { data, setQueryUrl, queryUrl, config } = props;
    const { ajax, Loading, open } = useAjax();
    const [openDrawer, setOpenDrawer] = React.useState(false);
    const [dataDrawer, setDataDrawer] = React.useState(false);

    const [confirmDelete, setConfirmDelete] = React.useState(0);

    const closeDialogConfirmDelete = () => {
        setConfirmDelete(0);
    };

    const history = useHistory();

    const eventClickRow = (type, id) => {

        ajax({
            url: `post-type/detail/${queryUrl.object}/${id}`,
            method: 'POST',
            isGetData: false,
            success: function (result) {
                if (result.post) {
                    result.type = queryUrl.object;
                    result.updatePost = new Date();
                    setDataDrawer({ ...result });
                    setOpenDrawer(true);
                }
            }
        });

    };

    const acctionPost = (payload, success) => {
        ajax({
            url: `post-type/get-data/${queryUrl.object}`,
            method: 'POST',
            isGetData: false,
            data: {
                ...queryUrl,
                ...payload,
            },
            success: function (result) {

                if (props.onEdit) {
                    props.onEdit();
                }

                if (success) {
                    success(result);
                }
            }
        });
    };


    const handleSubmit = () => {
        console.log(dataDrawer);

        if (!open) {
            ajax({
                url: 'post-type/post/' + dataDrawer.type,
                method: 'POST',
                data: { ...dataDrawer.post, _action: 'EDIT' },
                isGetData: false,
                success: (result) => {
                    if (result.post?.id) {
                        setOpenDrawer(false);
                        if (props.onEdit) {
                            props.onEdit();
                        }
                    }
                }
            });
        }

    };

    if (!data.rows.total) {
        return (
            <Table>
                <TableBody>
                    <TableRow>
                        <TableCell colSpan={100}>
                            <NotFound
                                subTitle={__('Seems like no {{data}} have been created yet.', {
                                    data: data.config.singularName
                                })} />
                        </TableCell>
                    </TableRow>
                </TableBody>
            </Table>
        )
    }

    return (
        <>
            <TableContainer component={Paper}>
                <Table>
                    <TableHead>
                        <TableRow>
                            {
                                Boolean(config && config.showFields) ?
                                    Object.keys(config.showFields).map(key => (
                                        <TableCell key={key}>{config.showFields[key].title}</TableCell>
                                    ))
                                    :
                                    (data.config.fields &&
                                        Object.keys(data.config.fields).map(key => (
                                            (data.config.fields[key].show_data !== false || data.config.fields[key].show_data === undefined)
                                                ?
                                                <TableCell key={key}>{data.config.fields[key].title}</TableCell>
                                                :
                                                <React.Fragment key={key}></React.Fragment>
                                        ))
                                    )
                            }

                            <TableCell padding="checkbox"></TableCell>
                        </TableRow>
                    </TableHead>
                    <TableBody>
                        {data.rows.data && data.rows.data[0] ?
                            data.rows.data.map((customer) => (
                                <TableRow
                                    hover
                                    className={classes.tr}
                                    onClick={e => eventClickRow(customer.type, customer.id)}
                                    data-id={customer.id}
                                    key={customer.id}
                                >
                                    {

                                        Boolean(config && config.showFields) ?
                                            Object.keys(config.showFields).map((key, index) => (
                                                index === 0 ?
                                                    <TableCell key={key}>
                                                        <Box display="flex" alignItems="center" >
                                                            <FieldView name={key} config={config.showFields[key]} compoment={config.showFields[key].view} post={customer} content={customer[key]} />
                                                            <LabelPost post={customer} />
                                                        </Box>
                                                    </TableCell>
                                                    :
                                                    <TableCell key={key}>
                                                        <FieldView name={key} config={config.showFields[key]} compoment={config.showFields[key].view} post={customer} content={customer[key]} />
                                                    </TableCell>
                                            ))
                                            :
                                            Object.keys(data.config.fields).filter(key => data.config.fields[key].show_data !== false || data.config.fields[key].show_data === undefined).map((key, index) => (
                                                index === 0 ?
                                                    <TableCell key={key}>
                                                        <Box display="flex" alignItems="center" >
                                                            <FieldView name={key} config={data.config.fields[key]} compoment={data.config.fields[key].view} post={customer} content={customer[key]} />
                                                            <LabelPost post={customer} />
                                                        </Box>
                                                    </TableCell>
                                                    :
                                                    <TableCell key={key}>
                                                        <FieldView name={key} config={data.config.fields[key]} compoment={data.config.fields[key].view} post={customer} content={customer[key]} />
                                                    </TableCell>
                                            ))
                                    }
                                    <TableCell>
                                        <ActionPost history={history} setConfirmDelete={setConfirmDelete} acctionPost={acctionPost} post={customer} postType={customer.type} />
                                    </TableCell>
                                </TableRow>
                            ))
                            :
                            <TableRow>
                                <TableCell colSpan={100}>
                                    <NotFound
                                        subTitle={__('Seems like no {{data}} have been created yet.', {
                                            data: data.config.singularName
                                        })} />
                                </TableCell>
                            </TableRow>
                        }
                    </TableBody>
                </Table>
            </TableContainer>
            <TablePagination
                component="div"
                count={data.rows.total * 1}
                onChangePage={(e, v) => { setQueryUrl({ ...queryUrl, page: v + 1 }); }}
                onChangeRowsPerPage={(e) => { setQueryUrl({ ...queryUrl, rowsPerPage: e.target.value }); }}
                page={data.rows.current_page * 1 - 1}
                rowsPerPage={data.rows.per_page * 1 || 10}
                rowsPerPageOptions={[5, 10, 25, 50, 100]}
            />
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
        </>
    )
}

export default DataTable
