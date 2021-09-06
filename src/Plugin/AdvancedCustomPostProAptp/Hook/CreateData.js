import { Card, CardContent, CardHeader, colors, Grid, makeStyles, Typography } from '@material-ui/core';
import React from 'react';
import { useAjax } from 'utils/useAjax';
import FieldForm from 'components/FieldForm';

const useStyles = makeStyles(() => ({
    cardHeader: {
        borderBottom: '1px solid',
        borderBottomColor: colors.grey[300],
    }
}));

function CreateData(props) {

    const classes = useStyles();
    const [render, setRender] = React.useState(0);

    const [template, setTemplate] = React.useState(false);

    const { ajax } = useAjax();

    React.useEffect(() => {

        try {
            if (props.data.post.meta) {
                if (typeof props.data.post.meta === 'string') {
                    props.data.post.meta = JSON.parse(props.data.post.meta);
                }
            }
        } catch (error) {

        }

        if (props.data.post.meta === null || typeof props.data.post.meta !== 'object') {
            props.data.post.meta = {};
        }

        setRender(render + 1);

        ajax({
            url: 'plugin/advanced-custom-post-pro-aptp/create-data/get',
            method: 'POST',
            data: {
                ...props.data.post,
                type: props.data.type
            },
            success: function (result) {
                if (result.template) {
                    setTemplate(result.template);
                }
            }
        });
        // setRender(render + 1);

    }, [props.data.updatePost]);

    React.useEffect(() => {



    }, [props.data.post.template]);

    const onReview = (key, value) => {

        if (!props.data.post.meta) props.data.post.meta = {};

        props.data.post.meta[key] = value;

        props.onReview(props.data.post.meta, 'meta');
    }

    if (props.data.post.meta !== null && typeof props.data.post.meta === 'object' && template) {
        props.data.post.aptp_field = [];

        return (
            <>
                {
                    template.map((item, index) => (
                        !item.templates || item.templates.indexOf(props.data.post.template) > -1 ?
                            <Grid key={index} item md={12} xs={12}>
                                <Card>
                                    <CardHeader
                                        title={<Typography variant="h5" >{item.title}</Typography>}
                                        className={classes.cardHeader}
                                    />
                                    <CardContent>
                                        <Grid
                                            container
                                            spacing={4}>
                                            {
                                                Object.keys(item.fields).map( key => {

                                                    props.data.post.aptp_field.push('aptp_meta_post_' + key);

                                                    return <Grid item md={12} xs={12} key={key} >
                                                        <FieldForm
                                                            compoment={item.fields[key].view ?? 'text'}
                                                            config={item.fields[key]}
                                                            post={props.data.post.meta['aptp_meta_post_' + key] ? props.data.post.meta : { ['aptp_meta_post_' + key]: '' }}
                                                            name={'aptp_meta_post_' + key}
                                                            onReview={(value, key2 = 'aptp_meta_post_' + key) => { onReview('aptp_meta_post_' + key, value) }}
                                                        />
                                                    </Grid>
                                                })
                                            }
                                        </Grid>
                                    </CardContent>
                                </Card>
                            </Grid>
                            : <React.Fragment key={index}></React.Fragment>
                    ))
                }

            </>

        )
    }

    return null;
}

export default CreateData