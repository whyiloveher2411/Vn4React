import { Card, CardContent, Checkbox, FormControlLabel, FormGroup, Grid } from '@material-ui/core';
import { CircularCustom, FieldForm } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import React from 'react';
import { usePermission } from 'utils/user';

function VerifyWebsite({ post, onReview, config }) {

    const permission = usePermission('plugin_vn4seo_setting').plugin_vn4seo_setting;

    React.useEffect(() => {

        if (!Array.isArray(post['seo/sitemap/post_type'])) {

            let postType = [];

            try {
                postType = JSON.parse(post['seo/sitemap/post_type']) ?? [];
            } catch (error) {
                postType = [];
            }
            onReview(postType, 'seo/sitemap/post_type');
        }

    }, []);


    const handleChangeSiteMap = (e) => {

        let result = post['seo/sitemap/post_type'];

        let checked = e.target.checked, v = e.target.value, index = result.indexOf(v);

        if (checked && index === -1) {
            result.push(v);
        } else if (!checked && index !== -1) {
            result.splice(index, 1);
        }

        onReview(result, 'seo/sitemap/post_type');
    }


    if (!permission) {
        return <RedirectWithMessage />
    }

    if (Array.isArray(post['seo/sitemap/post_type'])) {
        return (
            <>
                <Card style={parseInt(post['seo/sitemap/active']) === 1 ? {} : { opacity: '.2', pointerEvents: 'none', cursor: 'not-allowed' }}>
                    <CardContent style={{ position: 'relative', minHeight: 350 }}>
                        {
                            config.listPostType === false &&
                            <CircularCustom />
                        }
                        <FormGroup row>
                            <Grid container spacing={1}>
                                {
                                    config.listPostType &&
                                    Object.keys(config.listPostType).map(key => (
                                        <Grid key={key} item md={4} xs={12}>
                                            <FormControlLabel
                                                control={<Checkbox color="primary" value={key} checked={post['seo/sitemap/post_type'].indexOf(key) !== -1} onChange={handleChangeSiteMap} name="gilad" />}
                                                label={config.listPostType[key].title}
                                            />
                                        </Grid>
                                    ))
                                }

                            </Grid>
                        </FormGroup>
                    </CardContent>
                </Card>
            </>
        );
    }

    return <></>;

}

export default VerifyWebsite
