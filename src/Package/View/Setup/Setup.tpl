{{R3M}}
{{$register = Package.Raxon.Log:Init:register()}}
{{if(!is.empty($register))}}
{{Package.Raxon.Log:Import:role.system()}}
{{Package.Raxon.Log:Import:log.handler()}}
{{Package.Raxon.Log:Import:log.processor()}}
{{Package.Raxon.Log:Import:log()}}
{{/if}}