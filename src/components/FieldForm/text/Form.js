import { FormControl, FormHelperText, InputLabel, OutlinedInput } from '@material-ui/core';
import React from 'react';

export default React.memo(function TextForm(props) {
    const { config, post, onReview, name, ...rest } = props;
    let valueInital = post && post[name] ? post[name] : '';

    const [render, setRender] = React.useState(0);

    console.log('render TEXT');

    const handleOnChange = (e) => {
        post[name] = e.target.value;

        setRender(prev => prev + 1);
        onReview(post[name]);
    };


    return (
        <FormControl size={config.size ?? 'medium'} fullWidth variant="outlined">
            {
                Boolean(config.title) ?
                    <>
                        <InputLabel>{config.title}</InputLabel>
                        <OutlinedInput
                            type='text'
                            variant="outlined"
                            name={name}
                            value={valueInital}
                            label={config.title}
                            onBlur={e => { onReview(e.target.value); }}
                            onChange={e => { setRender(render + 1); post[name] = e.target.value }}
                            placeholder={config.placeholder ?? ''}
                            {...config.inputProps}
                            {...rest}
                        />
                    </>
                    :
                    <OutlinedInput
                        type='text'
                        variant="outlined"
                        name={name}
                        value={valueInital}
                        onBlur={handleOnChange}
                        onChange={handleOnChange}
                        placeholder={config.placeholder ?? ''}
                        {...rest}
                    />
            }

            {

                config.maxLength ?
                    <FormHelperText style={{ display: 'flex', justifyContent: 'space-between' }} >
                        {Boolean(config.note) && <span dangerouslySetInnerHTML={{ __html: config.note }}></span>}
                        <span style={{ marginLeft: 24, whiteSpace: 'nowrap' }}>{valueInital.length + '/' + config.maxLength}</span>
                    </FormHelperText>
                    :
                    config.note ?
                        <FormHelperText><span dangerouslySetInnerHTML={{ __html: config.note }}></span></FormHelperText>
                        : null
            }
        </FormControl>
    )

}, (props1, props2) => {
    return props1.post[props1.name] === props2.post[props2.name];
})

