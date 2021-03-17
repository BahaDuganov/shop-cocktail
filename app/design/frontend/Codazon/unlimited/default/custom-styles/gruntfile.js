/**
 * Aislend Demo
 */
module.exports = function (grunt) {
    const sass = require('node-sass');

    // Project Config
    grunt.initConfig({
        // Package File
        pkg: grunt.file.readJSON("package.json"),

        /* ======================================================================== */
        /* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
        /* ======================================================================== */

        /**
         * sass task
         * */
        sass: {
            options: {
                implementation: sass,
                sourceMap: false
            },
            dist: {
                files: [{
                    expand: true,
                    cwd: 'scss',
                    src: ["*.scss"],
                    dest: "../web/css/custom/",
                    ext: '.css'
                }]
            }
        },

        /* ======================================================================== */
        /* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
        /* ======================================================================== */

        /**
         *  Watch files for changes
         * */
        watch: {
            styles: {
                files: [
                    "scss/**/*.scss"
                ],
                tasks: ["sass", "copy"]
            }
        },

        /**
         * Apply vendor prefixes
         * */
        postcss: {
            options: {
                processors: [
                    require("autoprefixer")({
                        browsers: "last 2 versions"
                    }) // add vendor prefixes
                ]
            },
            dist: {
                src: '../web/css/custom/*.css'
            }
        },

        /**
         * combine media queries
         * */
        combine_mq: {
            options: {
                beautify: false
            },
            default_options: {
                expand: true,
                src: "../web/css/custom/*.css"
            }
        },

        // Static HTML dev sync
        browserSync: {
            dev: {
                bsFiles: {
                    src: [
                        "../web/css/custom/*.css",
                        'ui-html/*.html',
                        'ui-html/**/*.html'
                    ]
                },
                options: {
                    watchTask: true,
                    server: './ui-html'
                }
            }
        },

        copy: {
            main: {
                files: [
                    // includes files within path
                    {
                        expand: true,
                        cwd: '../web/css/custom/',
                        src: ['**'],
                        dest: '../../../../../../../pub/media/css/',
                        filter: 'isFile'},
                ],
            },
        }
    });

    /* ======================================================================== */
    /* xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx */
    /* ======================================================================== */


    // Sass
    grunt.loadNpmTasks("grunt-sass");

    // Watch changes
    grunt.loadNpmTasks("grunt-contrib-watch");

    // postcss task
    grunt.loadNpmTasks("grunt-postcss");

    // combine media queries
    grunt.loadNpmTasks("grunt-combine-mq");

    // Copy to pub media
    grunt.loadNpmTasks('grunt-contrib-copy');

    // Sync task
    grunt.loadNpmTasks('grunt-browser-sync');

    // Register Tasks
    grunt.registerTask("default", ["sass", "watch"]);

    // HTML sync
    grunt.registerTask("sync", ["sass", "browserSync", "watch"]);

    // production mode
    grunt.registerTask("prod", ["sass", "postcss", "combine_mq", "copy"]);
};
