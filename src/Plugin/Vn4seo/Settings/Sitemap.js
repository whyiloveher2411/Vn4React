import { Box, Card, CardContent, Checkbox, FormControlLabel, FormGroup, Grid } from '@material-ui/core';
import { CircularCustom, FieldForm, LoadingButton } from 'components';
import RedirectWithMessage from 'components/RedirectWithMessage';
import SettingEdit1 from 'components/Setting/SettingEdit1';
import React from 'react';
import { checkPermission } from 'utils/user';

function VerifyWebsite({ meta, ajaxPluginHandle, loading }) {

    console.log(meta);

    const [listPostType, setListPostType] = React.useState(false);
    const permission = checkPermission('plugin_vn4seo_setting');

    const valueInitial = {
        ['post-type-sitemap']: meta['post-type-sitemap'] ?? [],
        active_sitemap: meta['active_sitemap'],
    };

    const [value, setValue] = React.useState({
        old: JSON.parse(JSON.stringify(valueInitial)),
        new: JSON.parse(JSON.stringify(valueInitial)),
    });

    React.useEffect(() => {
        if (permission) {
            ajaxPluginHandle({
                url: 'settings/sitemap-get',
                data: {
                    action: 'getListPostType',
                },
                notShowLoading: true,
                success: (result) => {
                    if (result.listPostType) {
                        setListPostType(result.listPostType);
                    }
                }
            });
        }
    }, []);


    const handleSubmitSitemap = () => {
        if (listPostType !== false && !loading.open) {
            ajaxPluginHandle({
                url: 'settings/sitemap-post',
                data: {
                    ...value.new,
                    action: 'EditSitemap'
                },
            });
        }
    }

    const handleChangeSiteMap = (e) => {
        let checked = e.target.checked, v = e.target.value, index = value.new['post-type-sitemap'].indexOf(v);

        if (checked && index === -1) {

            let valueTempNew = JSON.parse(JSON.stringify(value));
            valueTempNew.new['post-type-sitemap'].push(v);
            setValue(valueTempNew);

        } else if (!checked && index !== -1) {
            let valueTempNew = JSON.parse(JSON.stringify(value));
            valueTempNew.new['post-type-sitemap'].splice(index, 1);
            setValue(valueTempNew);
        }

    }


    if (!permission) {
        return <RedirectWithMessage />
    }

    return (
        <SettingEdit1
            title="Sitemap"
            titleComponent={<>
                Sitemap
                <FieldForm
                    compoment='true_false'
                    config={{
                        title: ''
                    }}
                    post={value.new}
                    name={'active_sitemap'}
                    onReview={(v) => {

                        setValue(prev => {
                            let valueTempNew = JSON.parse(JSON.stringify(prev));
                            valueTempNew.new.active_sitemap = v;
                            return valueTempNew;
                        });

                    }}
                />
            </>}
            backLink="/plugin/vn4seo/settings"
            description="A sitemap is a file where you provide information about the pages, videos, and other files on your site, and the relationships between them. Search engines like Google read this file to crawl your site more efficiently. A sitemap tells Google which pages and files you think are important in your site, and also provides valuable information about these files. For example, when the page was last updated and any alternate language versions of the page."
        >
            <Card style={value.new.active_sitemap === 1 ? {} : { opacity: '.2', pointerEvents: 'none', cursor: 'not-allowed' }}>
                <CardContent style={{ position: 'relative', minHeight: 350 }}>
                    {
                        listPostType === false &&
                        <CircularCustom />
                    }
                    <FormGroup row>
                        <Grid container spacing={1}>
                            {
                                listPostType &&
                                Object.keys(listPostType).map(key => (
                                    <Grid key={key} item md={4} xs={12}>
                                        <FormControlLabel
                                            control={<Checkbox color="primary" value={key} checked={value.new['post-type-sitemap'].indexOf(key) !== -1} onChange={handleChangeSiteMap} name="gilad" />}
                                            label={listPostType[key].title}
                                        />
                                    </Grid>
                                ))
                            }

                        </Grid>
                    </FormGroup>
                </CardContent>
            </Card>
            <br />
            <Box display="flex" justifyContent="flex-end">

                <LoadingButton
                    className={'btn-green-save'}
                    onClick={handleSubmitSitemap}
                    variant="contained"
                    open={loading.open}
                >
                    Save Changes
                </LoadingButton>
            </Box>
        </SettingEdit1>
    );
}

export default VerifyWebsite
