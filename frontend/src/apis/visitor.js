"use strict";

import { date } from 'quasar';

// import axios from 'axios';
const tableColumns = () => {
        const textBreakClass = 'word-break: break-all; overflow: auto;white-space: pre-wrap;';
        return [{ 
            name: 'line',  
            label: 'Line', 
            align: 'left',
            field: 'line',
            sortable: true,
            filter: 'option'          // Filter Types: text, number, tags, option, range, date
        },
        { 
            name: 'skills',  
            label: 'Skillset',
            align: 'left', 
            style: 'width: 20vw; min-width: 240px;' + textBreakClass,
            field: 'skills',
            filter: 'tags'
        },
        { 
            name: 'about',  
            label: 'About',
            style: 'min-width: 380px;' + textBreakClass,
            align: 'left',
            field: 'about',
            format: val => `${val}`, 
            filter: 'text'
        },
        { 
            name: 'available', 
            label: 'Available',
            align: 'left', 
            field: 'available', 
            format: val => {
                const currentDate = date.formatDate(new Date(), 'YYYY-MM-DD');
                const availableDate = date.formatDate(val, 'YYYY-MM-DD')
                console.log(currentDate < availableDate)
                return (date.getDateDiff(currentDate, availableDate, 'days'))// ? '' : date.formatDate(val, 'DD-MM-YYYY');
            },
            sortable: true, 
            filter: 'date'
        },
        { 
            name: 'name',  
            label: 'Entity', 
            align: 'left',
            field: 'name',
            format: val => `${val}`,
            sortable: true,
            filter: 'text'          // Filter Types: text, number, tags, option, range, date
        },
        { 
            name: 'ops', 
            label: 'Ops.',
            align: 'center', 
            field: 'ops', 
            sortable: true, 
            sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
            filter: 'number'
        },
        // { 
        //     name: 'pricerange', 
        //     label: 'Pricerange',
        //     align: 'left', 
        //     field: 'pricerange',
        //     sortable: true, 
        //     sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
        //     filter: 'range'
        // },
        { 
            name: 'reviews', 
            label: 'Reviews',
            align: 'center', 
            field: 'reviews', 
            sortable: true, 
            sort: (a, b) => parseInt(a, 10) - parseInt(b, 10),
            filter: 'number'
        },
    ];
}
const tableRows = () => {
    return [
        {
            key: 0,                         // Parent: EntityKEY
            available: '06.11.2022',
            line: 'IT',
            name: 'bumaEnitity',
            about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            skills: [
                {
                    key: 0,
                    label: 'asdf'
                },
                {
                    key: 1,
                    label: 'fffff'
                },
                {
                    key: 2,
                    label: 'ggf'
                },
                {
                    key: 3,
                    label: '44234'
                },{
                    key: 3,
                    label: 'ggdr'
                },{
                    key: 3,
                    label: '234gg'
                },{
                    key: 3,
                    label: '6345'
                },{
                    key: 3,
                    label: 'sfccf'
                }
            ],
            ops: 4,
            pricerange: 10000.20,
            reviews: 34,
        },{
            key: 1,
            available: '01.01.2023',
            line: 'IT',
            name: 'bumaEnitity2',
            about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            skills: [
                {
                    key: 0,
                    label: 'asdf'
                },
                {
                    key: 1,
                    label: 'fffff'
                },
                {
                    key: 2,
                    label: 'ggf'
                },
                {
                    key: 3,
                    label: '444kkg'
                },{
                    key: 3,
                    label: '64'
                },{
                    key: 3,
                    label: 'vssdf'
                },{
                    key: 3,
                    label: '64kk'
                },{
                    key: 3,
                    label: 'vxcv'
                }
            ],
            ops: 1,
            pricerange: 190.20,
            reviews: 12,
        },{
            key: 2,
            available: '03.11.2022',
            line: 'Service',
            name: 'Company2',
            about: 'Wir sind eine unabhängige Kompanie mit dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            skills: [
                {
                    key: 0,
                    label: '6456'
                },
                {
                    key: 1,
                    label: 'fffff'
                },
                {
                    key: 2,
                    label: 'ggf'
                },
                {
                    key: 3,
                    label: '534555345'
                },{
                    key: 3,
                    label: '64kk'
                },{
                    key: 3,
                    label: 'swer'
                },{
                    key: 3,
                    label: 'vxcv'
                },{
                    key: 3,
                    label: 'ljljkljkl'
                }
            ],
            ops: 2,
            pricerange: 500,
            reviews: 134,
        },
    ]
}

const tableCards = () => {
    return [
        {
            key: 0,
            entityKey: 0,
            entity: 'EntityName',
            gigKey: 0,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'Das ist unser Event dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            pricerange: [120000, 160000],
            likes: 12,
            duration: 7 + ' weeks',
            progess: {},
            ops: 3,
            skills: [
                {
                    id: 0,
                    label: 'Vue3',
                    available: false
                },{
                    id: 40,
                    label: 'Laravel & SQL',
                    available: true
                },{
                    id: 2,
                    label: 'Full Stack Webdevelopment',
                    available: false
                },{
                    id: 20,
                    label: 'Scrum',
                    available: true
                },
            ]
        }, {
            key: 1,
            entityKey: 1,
            entity: 'EntityName',
            gigKey: 1,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'sdfasdfw wer wer wers dfsdw er dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            pricerange: [1200, 3000],
            likes: 32,
            duration: 4 + ' weeks',
            progess: {},
            ops: 2,
            skills: [
                {
                    id: 90,
                    label: 'UX Design',
                    available: true
                }
            ]
        }, {
            key: 2,
            entityKey: 2,
            entity: 'EntityName',
            gigKey: 2,
            title: 'GigTitle',
            start: '10.12.2023',
            about: 'Das ist unser Event dwsx kdfsfoie sfsdf s,sflkf aidfou asdf  oausdf  asdf kjlas df ajasdlfja lsdjflaj ds lfja',
            pricerange: [1200000, 167000],
            likes: 11,
            duration: 12 + ' weeks',
            progess: {},
            ops: 12,
            skills: [
                {
                    id: 90,
                    label: 'UX Design',
                    available: true
                },{
                    id: 2,
                    label: 'Full Stack Webdevelopment',
                    available: false
                },{
                    id: 20,
                    label: 'Scrum',
                    available: true
                },
            ]
        }
    ]
}

export { 
    tableColumns,
    tableRows,
    tableCards
}