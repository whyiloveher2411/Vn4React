import { Fab, FormHelperText, Slide, Typography } from '@material-ui/core';
import AddRoundedIcon from '@material-ui/icons/AddRounded';
import { NotFound } from 'components';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import DataTable from './DataTable';
import DrawerEditPost from './DrawerEditPost';

export default React.memo(function RelationshipOneToManyShowForm(props) {
    let { config, post } = props;

    const [data, setData] = React.useState(false);
    const [openDrawer, setOpenDrawer] = React.useState(false);
    const { ajax, open } = useAjax();

    const [queryUrl, setQueryUrl] = React.useState({
        ...config,
        mainType: post.type,
        id: post.id,
        page: 1,
        rowsPerPage: 5
    });

    const handleOnClose = () => {
        setOpenDrawer(false);
    }

    const handelOnOpen = () => {
        setOpenDrawer(true);
    }

    const onLoadCollection = () => {
        ajax({
            url: 'post-type/show-post-relationship',
            method: 'POST',
            data: queryUrl,
            success: (result) => {
                if (result.rows) {
                    result.action = 'ADD_NEW';
                    setData({ ...result, type: config.object });
                }
            }
        });
    };

    React.useEffect(() => {
        if (post.id) {
            onLoadCollection();
        } else {
            setData(false);
        }
    }, [queryUrl]);

    const handleSubmit = () => {

        if (!open) {
            ajax({
                url: 'post-type/post/' + config.object,
                method: 'POST',
                data: { ...data.post, _action: data.action },
                isGetData: false,
                success: (result) => {
                    if (result.post?.id) {
                        setOpenDrawer(false);
                        onLoadCollection();
                    }
                }
            });
        }

    };


    if (!post.id) {
        return (<>
            <Typography variant="h5" style={{ margin: '8px 0' }}>
                {config.title}
            </Typography>
            {
                Boolean(config.note) &&
                <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
            }
            <NotFound>
                You need to create taxonomy before creating {config.title}. <br />
                <span style={{ color: '#ababab', fontSize: '16px' }}>Seems like no {data?.config?.label?.singularName ?? ""} have been created yet.</span>
            </NotFound>
        </>);
    }

    return (
        <div>
            <Typography variant="h5" style={{ margin: '8px 0' }}>
                {config.title}
                {
                    Boolean(data) &&
                    < Fab onClick={handelOnOpen} style={{ marginLeft: 8 }} size="small" color="primary" aria-label="add">
                        <AddRoundedIcon />
                    </Fab>
                }
            </Typography>
            {
                Boolean(config.note) &&
                <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
            }
            {
                data !== false && post.id &&
                <>
                    <DataTable
                        requestApi={{ ...config, id: post.id }}
                        setQueryUrl={setQueryUrl}
                        queryUrl={queryUrl}
                        data={data}
                        onEdit={onLoadCollection}
                        editTemplate="1column"
                        config={config}
                    />
                    <DrawerEditPost
                        open={openDrawer}
                        onClose={handleOnClose}
                        data={data}
                        handleSubmit={handleSubmit}
                        showLoadingButton={open}
                    />
                </>
            }
        </div >
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name] && props1.post?.id === props2.post?.id;
})

