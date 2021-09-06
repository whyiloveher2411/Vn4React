import { FormControl, FormHelperText, InputLabel, OutlinedInput } from '@material-ui/core';
import React from 'react';

export default React.memo(function NumberForm(props) {
    const { config, post, onReview, name, ...rest } = props;
    let valueInital = post && post[name] ? post[name] : '';

    const [value, setValue] = React.useState(0);

    console.log('render NUMBER');

    return (
        <FormControl size={config.size ?? 'medium'} fullWidth variant="outlined">
            {
                Boolean(config.title) ?
                    <>
                        <InputLabel>{config.title}</InputLabel>
                        <OutlinedInput
                            type='number'
                            variant="outlined"
                            name={name}
                            value={valueInital}
                            label={config.title}
                            labelWidth={config.title.length * 8}
                            onBlur={e => { onReview(e.target.value) }}
                            onChange={e => { setValue(value + 1); post[name] = e.target.value }}
                            {...rest}
                        />
                    </>
                    :
                    <OutlinedInput
                        type='number'
                        variant="outlined"
                        name={name}
                        value={valueInital}
                        labelWidth={config.title.length * 8}
                        onBlur={e => { onReview(e.target.value) }}
                        onChange={e => { setValue(value + 1); post[name] = e.target.value }}
                        {...rest}
                    />
            }
            {
                Boolean(config.note) &&
                <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
            }
        </FormControl>
    )

}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})

