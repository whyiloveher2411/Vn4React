import { FormControl, FormHelperText, InputLabel, OutlinedInput } from '@material-ui/core';
import React from 'react';

export default function NumberForm(props) {
    const { config, post, onReview, name, ...rest } = props;
    let valueInital = post && post[name] ? Number((parseFloat(post[name])).toFixed(6)) : '';

    const [value, setValue] = React.useState(0);

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
                            {...config.inputProps}
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
                        {...config.inputProps}
                        {...rest}
                    />
            }
            {
                Boolean(config.note) &&
                <FormHelperText ><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
            }
        </FormControl>
    )
}
