import { Collapse, FormControl, FormControlLabel, FormHelperText, Grid, Radio, RadioGroup, Typography } from '@material-ui/core';
import FieldForm from 'components/FieldForm';
import React from 'react';
import { __ } from 'utils/i18n';

function DateTimeFormat(props) {
    let { config, name, post, onReview } = props;

    let valueInital = {};

    try {
        if (typeof post[name] === 'object') {
            valueInital = post[name];
        } else {
            if (post[name] && post[name]) {
                valueInital = JSON.parse(post[name]);
            }
        }
    } catch (error) {
        valueInital = {};
    }

    post[name] = valueInital;

    const [value, setValue] = React.useState(post[name]);

    React.useEffect(() => {
        setValue((post && post[name]) ? post[name] : '');
    }, [post]);

    React.useEffect(() => {
        onReview(value);
    }, [value]);

    return (
        <FormControl fullWidth component="fieldset">
            <Typography>{config.title}</Typography>
            <RadioGroup aria-label={config.title} name={name} value={value}>
                <FormControlLabel onClick={() => setValue({ ...post[name], type: 'default' })} value={'default'} control={<Radio checked={value.type === 'default'} color="primary" />} label={__('Default')} />
                <FormControlLabel style={{ marginTop: 10 }} onClick={() => setValue({ ...post[name], type: 'static-page' })} value={'static-page'} control={<Radio checked={value.type === 'static-page'} color="primary" />} label={__('A Static Page')} />
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%', marginTop: 10 }} in={value.type === 'static-page'}>
                    <Grid
                        container
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'select'}
                                config={{
                                    title: __('Page'),
                                    list_option: config.readingPageStatic,
                                    disableClearable: true
                                }}
                                post={value}
                                name={'static-page'}
                                onReview={v => { setValue({ ...post[name], type: 'static-page', 'static-page': v }) }}
                            />
                        </Grid>
                    </Grid>
                </Collapse>
                <FormControlLabel onClick={() => setValue({ ...post[name], type: 'custom' })} value={'custom'} control={<Radio checked={value.type === 'custom'} color="primary" />} label={__('Custom')} />
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%', marginTop: 10 }} in={value.type === 'custom'}>
                    <Grid
                        container
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'select'}
                                config={{
                                    title: __('Posts'),
                                    list_option: config.adminObject,
                                    disableClearable: true,
                                }}
                                post={value}
                                name={'post-type'}
                                onReview={(v) => {
                                    setValue(() => ({ ...post[name], type: 'custom', 'post-type': v, 'post-id': false, 'post-id_detail': '' }));
                                }}
                            />
                        </Grid>


                        <Grid item md={12} xs={12} >
                            {
                                Boolean(value['post-type']) &&
                                <FieldForm
                                    compoment={'relationship_onetomany'}
                                    config={{
                                        title: __('Detail'),
                                        object: value['post-type']
                                    }}
                                    post={value}
                                    name={'post-id'}
                                    onReview={(key, v) => {
                                        console.log(v); setValue({
                                            ...value,
                                            'post-id': v['post-id'],
                                            'post-id_detail': {
                                                id: v['post-id_detail'].id,
                                                title: v['post-id_detail'].title,
                                            }
                                        })
                                    }}
                                />
                            }

                        </Grid>
                    </Grid>
                </Collapse>
            </RadioGroup>
            <FormHelperText>{config.note}</FormHelperText>
        </FormControl>
    )
}

export default DateTimeFormat
