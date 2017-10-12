module.exports = (grunt) ->
  grunt.initConfig

    # =============================================
    # VARIABLES
    # =============================================
    ScssDirectory: 'dev/scss'
    CoffeeDirectory: 'dev/coffee'
    ResourcesDirectory: 'formbuilderslacknotifications/resources'

    # =============================================
    # WATCH FOR CHANGE
    # =============================================
    watch:
      css:
        files: ['<%= ScssDirectory %>/**/*']
        tasks: ['sass']
      scripts:
        files: ['<%= CoffeeDirectory %>/*']
        tasks: ['coffee']
      options:
        livereload: false

    # =============================================
    # SASS COMPILE
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-sass
    # =============================================
    sass:
      compile:
        options:
          compress: false
          sourcemap: 'none'
          style: 'nested'
        files:
          '<%= ResourcesDirectory %>/css/slacknotifications.css': '<%= ScssDirectory %>/slacknotifications.scss'

    # =============================================
    # COFFEE COMPILING
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-coffee
    # =============================================
    coffee:
      options:
        join: true
        bare: true
      compile:
        files:
          '<%= ResourcesDirectory %>/js/slacknotifications.js': ['<%= CoffeeDirectory %>/slacknotifications.coffee']

    # =============================================
    # UGLIFY JAVASCRIPT
    # =============================================
    # https://github.com/gruntjs/grunt-contrib-uglify
    # =============================================
    uglify:
      options:
        sourceMap: true
        mangle: false
        beautify: false
        compress: true
      dist:
        files:
          '<%= ResourcesDirectory %>/js/slacknotifications.min.js': ['<%= ResourcesDirectory %>/js/slacknotifications.js']

    # =============================================
    # LOAD PLUGINS
    # =============================================
    grunt.loadNpmTasks 'grunt-contrib-sass'
    grunt.loadNpmTasks 'grunt-contrib-coffee'
    grunt.loadNpmTasks 'grunt-contrib-watch'
    grunt.loadNpmTasks 'grunt-contrib-uglify'

    # =============================================
    # TASKS
    # =============================================
    grunt.registerTask 'default', ['watch']
    grunt.registerTask 'minify', ['uglify']