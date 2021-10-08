import { FormControl, FormControlLabel, FormHelperText, Radio, RadioGroup, Typography } from '@material-ui/core';
import React from 'react';

export default React.memo(function RadioField(props) {
    let { config, name, post, onReview } = props;

    let valueInital = post && post[name] ? post[name] : '';

    const [value, setValue] = React.useState(0);

    console.log('render RADIO');
    return (
        <FormControl component="fieldset">
            <Typography>{config.title}</Typography>
            <RadioGroup
                aria-label={config.title}
                name={name}
                value={valueInital}
                {...config}
                onChange={e => { post[name] = valueInital = e.target.value; onReview(e.target.value); setValue(value + 1); }}
            >
                {
                    Object.keys(config.list_option).map(key =>
                        <FormControlLabel key={key} value={key} control={<Radio color="primary" />} label={config.list_option[key].title} />
                    )
                }
            </RadioGroup>
            <FormHelperText>{config.note}</FormHelperText>
        </FormControl>
    )
}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})
