import React from 'react'
import { useParams } from 'react-router-dom';
import { toCamelCase } from '../utils/helper';
import NotFound from './NotFound/NotFound';
import TemplatesAdmin from './TemplatesAdmin';

function OnePage() {

    let { page, tab, subTab } = useParams();

    if (page) {
        try {
            let compoment = toCamelCase(page);
            // if (tab) {
            //     let resolved = require(`./OnePage/${toCamelCase(page)}/${toCamelCase(tab)}`).default;
            //     return React.createElement(resolved, { page: page });
            // } else {

            if (subTab) {
                let resolved = require(`./OnePage/${compoment}` + '/' + toCamelCase(tab)).default;
                return React.createElement(resolved, { page: page });
            }

            let resolved = require(`./OnePage/${compoment}`).default;
            return React.createElement(resolved, { page: page });
            // }
        } catch (error) {
            return <TemplatesAdmin
                page={page}
                tab={tab}
                subTab={subTab}
            />
        }
    }


    let resolved = require('./Home').default;
    return React.createElement(resolved, { page: page });


}

export default OnePage
