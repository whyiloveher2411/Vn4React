import { Hook } from 'components';
import SettingBlock1 from 'components/Setting/SettingBlock1';
import SettingBlock2 from 'components/Setting/SettingBlock2';
import SettingScreen1 from 'components/Setting/SettingScreen1';
import React from 'react';

function Setting({ title, subTitle, settings }) {

    return (
        <SettingScreen1
            title={title}
            subTitle={subTitle}
        >
            {
                settings.map((setting, index) => {
                    switch (setting.template) {
                        case 'Hook':
                            return <Hook hook={setting.Hook} key={index} {...setting} />
                        case 'SettingBlock2':
                            return <SettingBlock2
                                key={index}
                                {...setting}
                            />
                        case 'SettingBlock1':
                            return <SettingBlock1
                                key={index}
                                {...setting}
                            />
                    }
                })
            }
        </SettingScreen1>
    );
}

export default Setting
