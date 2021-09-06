import { Collapse, FormControl, FormControlLabel, FormHelperText, FormLabel, Grid, Radio, RadioGroup, TextField } from '@material-ui/core'
import React from 'react'
import { useAjax } from 'utils/useAjax';
import FieldForm from 'components/FieldForm';

function DateTimeFormat(props) {
    let { config, name, post, onReview } = props;

    const { ajax } = useAjax();

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
            <FormLabel component="legend">{config.title}</FormLabel>
            <RadioGroup aria-label={config.title} name={name} value={value}>
                <FormControlLabel onClick={() => setValue({ ...post[name], type: 'default' })} value={'default'} control={<Radio checked={value.type === 'default'} color="primary" />} label='Default' />
                <FormControlLabel onClick={() => setValue({ ...post[name], type: 'static-page' })} value={'static-page'} control={<Radio checked={value.type === 'static-page'} color="primary" />} label='A Static Page' />
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%' }} in={value.type === 'static-page'}>
                    <Grid
                        container
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'select'}
                                config={{
                                    title: 'Page',
                                    list_option: config.readingPageStatic
                                }}
                                post={value}
                                name={'static-page'}
                                onReview={v => { setValue({ ...post[name], 'static-page': v }) }}
                            />
                        </Grid>
                    </Grid>
                </Collapse>
                <FormControlLabel onClick={() => setValue({ ...post[name], type: 'custom' })} value={'custom'} control={<Radio checked={value.type === 'custom'} color="primary" />} label='Custom' />
                <Collapse style={{ paddingLeft: 16, paddingRight: 16, width: '100%' }} in={value.type === 'custom'}>
                    <Grid
                        container
                        spacing={4}>
                        <Grid item md={12} xs={12} >
                            <FieldForm
                                compoment={'select'}
                                config={{
                                    title: 'Post Type',
                                    list_option: config.adminObject,
                                    disableClearable: true,
                                }}
                                post={value}
                                name={'post-type'}
                                onReview={(v) => {
                                    setValue(() => ({ ...post[name], 'post-type': v, 'post-id': false, 'post-id_detail': '' }));
                                }}
                            />
                        </Grid>


                        <Grid item md={12} xs={12} >
                            {
                                Boolean(value['post-type']) &&
                                <FieldForm
                                    compoment={'relationship_onetomany'}
                                    config={{
                                        title: 'Detail',
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
