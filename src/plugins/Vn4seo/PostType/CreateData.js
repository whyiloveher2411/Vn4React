import { Card, CardContent, CardHeader, Grid, Tooltip, Typography } from '@material-ui/core';
import CodeRoundedIcon from '@material-ui/icons/CodeRounded';
import SearchIcon from '@material-ui/icons/Search';
import ShareRoundedIcon from '@material-ui/icons/ShareRounded';
import { Divider } from 'components';
import TabsCustom from 'components/TabsCustom';
import React from 'react';
import { General, Schema, Social } from '../compoments/SEOPostType';

function CreateData(props) {

    const [render, setRender] = React.useState(0);

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

    }, [props.data.updatePost]);

    const onReview = (key, value) => {

        if (!props.data.post.meta) props.data.post.meta = {};

        props.data.post.meta[key] = value;
    }

    if (props.data.post.meta !== null && typeof props.data.post.meta === 'object' && props.data.config?.public_view) {

        return (
            <Grid item md={12} xs={12}>
                <Card>
                    <CardHeader
                        title={<Typography variant="h5" >Search Engine Optimization</Typography>}
                    />
                    <Divider />
                    <CardContent>
                        <TabsCustom name="vn4seo_createdata" orientation='vertical' tabIcon={true} tabs={[
                            {
                                title: <Tooltip title="General"><SearchIcon /></Tooltip>,
                                content: () => <General data={props.data.post.meta} onReview={onReview} />
                            },
                            {
                                title: <Tooltip title="Social"><ShareRoundedIcon /></Tooltip>,
                                content: () => <Social data={props.data.post.meta} onReview={onReview} />
                            },
                            {
                                title: <Tooltip title="Json-LD"><CodeRoundedIcon /></Tooltip>,
                                content: () => <Schema data={props.data.post.meta} onReview={onReview} />
                            }
                        ]} />
                    </CardContent>
                </Card>
            </Grid>
        )
    }

    return null;
}

export default CreateData
